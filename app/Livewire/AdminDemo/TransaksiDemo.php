<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\PaySetting;
use App\Models\Data;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class TransaksiDemo extends Component
{
    use WithPagination;

    public string $search = '';

    public ?string $statusTrans = null;

    public ?string $typeTrans = null;

    public ?int $idTrans = null;

    public string $createUserId = '';

    public string $createDataId = '';

    public string $createTotal = '';

    public string $createPaymentType = 'cash';

    public string $createPaymentStatus = Transaction::STATUS_PENDING;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $transactions = Transaction::query()
            ->with(['data', 'user'])
            ->when(!empty(trim($this->search)), function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('invoice', 'like', $searchTerm)
                        ->orWhere('payment_status', 'like', $searchTerm)
                        ->orWhere('payment_type', 'like', $searchTerm)
                        ->orWhereHas('user', function ($uQuery) use ($searchTerm) {
                            $uQuery->where('name', 'like', $searchTerm)
                                ->orWhere('email', 'like', $searchTerm);
                        });
                });
            })
            ->latest('id')
            ->paginate(10);

        $selectedData = $this->createUserId
            ? Data::where('user_id', $this->createUserId)->latest('id')->first(['id', 'title'])
            : null;

        return view('livewire.admin-demo.transaksi-demo', [
            'transactions' => $transactions,
            'users' => User::orderBy('name')->get(['id', 'name', 'email']),
            'selectedData' => $selectedData,
            'paymentMethods' => PaySetting::where('isActive', true)->orderBy('bank')->get(['id', 'bank', 'category']),
        ])->layout('components.layouts.admin-new');
    }

    public function openCreate(): void
    {
        $this->resetCreateForm();
        $this->dispatch('open-modal', name: 'create-transaksi-modal');
    }

    public function updatedCreateUserId(): void
    {
        $this->createDataId = (string) (Data::where('user_id', $this->createUserId)->latest('id')->value('id') ?? '');
    }

    public function create(): void
    {
        $validated = $this->validate([
            'createUserId' => ['required', 'exists:users,id'],
            'createDataId' => ['required', 'exists:data,id'],
            'createTotal' => ['required', 'numeric', 'min:0'],
            'createPaymentType' => ['required', 'string', 'max:255'],
            'createPaymentStatus' => ['required', 'in:SUCCESS,SETTLEMENT,PENDING,CANCEL,FAILED,EXPIRED,CHALLENGE'],
        ], [
            'createUserId.required' => 'User wajib dipilih.',
            'createDataId.required' => 'Produk user tidak ditemukan.',
            'createTotal.required' => 'Total wajib diisi.',
            'createPaymentType.required' => 'Metode pembayaran wajib dipilih.',
            'createPaymentStatus.required' => 'Status pembayaran wajib dipilih.',
        ]);

        DB::transaction(function () use ($validated) {
            $data = Data::where('id', $validated['createDataId'])
                ->where('user_id', $validated['createUserId'])
                ->firstOrFail();

            // Unique Invoice Generation
            do {
                $invoice = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            } while (Transaction::where('invoice', $invoice)->exists());

            $transaction = Transaction::create([
                'invoice' => $invoice,
                'user_id' => $validated['createUserId'],
                'data_id' => $data->id,
                'link_snap' => '',
                'kode' => '',
                'price' => (int) $validated['createTotal'],
                'promo' => 0,
                'gross_amount' => (int) $validated['createTotal'],
                'payment_status' => strtoupper($validated['createPaymentStatus']),
                'payment_type' => $validated['createPaymentType'],
            ]);

            $this->syncDataActivation($transaction);
        });

        $this->resetCreateForm();
        $this->resetPage();

        session()->flash('message', 'Transaksi berhasil dibuat.');
        $this->dispatch('close-modal', name: 'create-transaksi-modal');
    }

    public function edit(int $id): void
    {
        $t = Transaction::findOrFail($id);
        $this->idTrans = $id;
        $this->statusTrans = $t->payment_status;
        $this->typeTrans = $t->payment_type;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'transaksi-modal');
    }

    public function update(): void
    {
        if (!$this->idTrans) {
            return;
        }

        $this->validate([
            'statusTrans' => ['required', 'string'],
            'typeTrans' => ['required', 'string'],
        ]);

        DB::transaction(function () {
            $t = Transaction::findOrFail($this->idTrans);
            $t->update([
                'payment_status' => strtoupper($this->statusTrans),
                'payment_type' => $this->typeTrans,
            ]);

            $this->syncDataActivation($t);
        });

        session()->flash('message', 'Transaksi berhasil diperbarui.');
        $this->dispatch('close-modal', name: 'transaksi-modal');
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $transaction = Transaction::findOrFail($id);
            $dataId = $transaction->data_id;
            $transaction->delete();

            // Re-evaluate data activation based on remaining successful transactions
            if ($dataId) {
                $hasOtherSuccess = Transaction::where('data_id', $dataId)
                    ->where('id', '!=', $id)
                    ->get()
                    ->contains(fn ($t) => Transaction::isSuccessfulStatus($t->payment_status));

                Data::where('id', $dataId)->update(['isActive' => $hasOtherSuccess ? 1 : 0]);
            }
        });

        session()->flash('message', 'Transaksi berhasil dihapus.');
    }

    protected function resetCreateForm(): void
    {
        $this->reset([
            'createUserId',
            'createDataId',
            'createTotal',
        ]);
        $this->createPaymentType = 'cash';
        $this->createPaymentStatus = Transaction::STATUS_PENDING;
        $this->resetValidation();
    }

    protected function syncDataActivation(Transaction $transaction): void
    {
        $data = Data::find($transaction->data_id);
        if ($data) {
            $isSuccess = Transaction::isSuccessfulStatus($transaction->payment_status);
            $data->isActive = $isSuccess ? 1 : 0;
            $data->save();
        }
    }
}
