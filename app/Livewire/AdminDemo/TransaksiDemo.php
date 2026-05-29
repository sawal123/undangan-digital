<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\PaySetting;
use App\Models\Data;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class TransaksiDemo extends Component
{
    use WithPagination;

    public $search = '';
    public $statusTrans, $typeTrans, $idTrans;
    public $createUserId = '';
    public $createDataId = '';
    public $createTotal = '';
    public $createPaymentType = 'cash';
    public $createPaymentStatus = 'PENDING';

    public function render()
    {
        $transactions = Transaction::query()
            ->with(['data', 'user'])
            ->when($this->search, function ($query) {
                $query->where('payment_status', 'like', "%{$this->search}%")
                    ->orWhere('payment_type', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        $selectedData = $this->createUserId
            ? Data::where('user_id', $this->createUserId)->latest()->first(['id', 'title'])
            : null;

        return view('livewire.admin-demo.transaksi-demo', [
            'transactions' => $transactions,
            'users' => User::orderBy('name')->get(['id', 'name', 'email']),
            'selectedData' => $selectedData,
            'paymentMethods' => PaySetting::where('isActive', true)->orderBy('bank')->get(['id', 'bank', 'category']),
        ])->layout('components.layouts.admin-new');
    }

    public function openCreate()
    {
        $this->resetCreateForm();
        $this->dispatch('open-modal', name: 'create-transaksi-modal');
    }

    public function updatedCreateUserId()
    {
        $this->createDataId = Data::where('user_id', $this->createUserId)->latest()->value('id') ?? '';
    }

    public function create()
    {
        $validated = $this->validate([
            'createUserId' => ['required', 'exists:users,id'],
            'createDataId' => ['required', 'exists:data,id'],
            'createTotal' => ['required', 'numeric', 'min:0'],
            'createPaymentType' => ['required', 'string', 'max:255'],
            'createPaymentStatus' => ['required', 'in:SUCCESS,PENDING,CANCEL,FAILED,EXPIRED'],
        ], [
            'createUserId.required' => 'User wajib dipilih.',
            'createDataId.required' => 'Produk user tidak ditemukan.',
            'createTotal.required' => 'Total wajib diisi.',
            'createPaymentType.required' => 'Metode pembayaran wajib dipilih.',
            'createPaymentStatus.required' => 'Status pembayaran wajib dipilih.',
        ]);

        $data = Data::where('id', $validated['createDataId'])
            ->where('user_id', $validated['createUserId'])
            ->firstOrFail();

        $transaction = Transaction::create([
            'invoice' => 'INV-' . strtoupper(Str::random(8)),
            'user_id' => $validated['createUserId'],
            'data_id' => $data->id,
            'link_snap' => '',
            'kode' => '',
            'price' => $validated['createTotal'],
            'promo' => 0,
            'gross_amount' => $validated['createTotal'],
            'payment_status' => $validated['createPaymentStatus'],
            'payment_type' => $validated['createPaymentType'],
        ]);

        $this->syncDataActivation($transaction);
        $this->resetCreateForm();
        $this->resetPage();

        session()->flash('message', 'Transaksi berhasil dibuat.');
        $this->dispatch('close-modal', name: 'create-transaksi-modal');
    }

    public function edit($id)
    {
        $t = Transaction::findOrFail($id);
        $this->idTrans = $id;
        $this->statusTrans = $t->payment_status;
        $this->typeTrans = $t->payment_type;
        $this->dispatch('open-modal', name: 'transaksi-modal');
    }

    public function update()
    {
        $t = Transaction::findOrFail($this->idTrans);
        $t->update([
            'payment_status' => $this->statusTrans,
            'payment_type' => $this->typeTrans,
        ]);

        $this->syncDataActivation($t);

        session()->flash('message', 'Transaksi successfully updated.');
        $this->dispatch('close-modal', name: 'transaksi-modal');
    }

    public function delete($id)
    {
        Transaction::findOrFail($id)->delete();
        session()->flash('message', 'Transaksi successfully deleted.');
    }

    protected function resetCreateForm()
    {
        $this->reset([
            'createUserId',
            'createDataId',
            'createTotal',
        ]);
        $this->createPaymentType = 'cash';
        $this->createPaymentStatus = 'PENDING';
        $this->resetValidation();
    }

    protected function syncDataActivation(Transaction $transaction)
    {
        $data = Data::find($transaction->data_id);
        if ($data) {
            $data->isActive = in_array($transaction->payment_status, ['SUCCESS', 'SETTLEMENT'], true) ? 1 : 0;
            $data->save();
        }
    }
}
