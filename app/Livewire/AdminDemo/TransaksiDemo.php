<?php

namespace App\Livewire\AdminDemo;

use App\Models\Data;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class TransaksiDemo extends Component
{
    use WithPagination;

    public $search = '';
    public $statusTrans, $typeTrans, $idTrans;

    public function render()
    {
        $transactions = Transaction::query()
            ->when($this->search, function ($query) {
                $query->where('payment_status', 'like', "%{$this->search}%")
                    ->orWhere('payment_type', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin-demo.transaksi-demo', [
            'transactions' => $transactions,
        ])->layout('components.layouts.admin-new');
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

        $data = Data::find($t->data_id);
        if ($data) {
            $data->isActive = ($this->statusTrans === 'SUCCESS' || $this->statusTrans === 'SETTLEMENT') ? 1 : 0;
            $data->save();
        }

        session()->flash('message', 'Transaksi successfully updated.');
        $this->dispatch('close-modal', name: 'transaksi-modal');
    }

    public function delete($id)
    {
        Transaction::findOrFail($id)->delete();
        session()->flash('message', 'Transaksi successfully deleted.');
    }
}
