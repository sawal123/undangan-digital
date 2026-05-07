<?php

namespace App\Livewire\AdminDemo;

use Livewire\Component;
use Livewire\WithPagination;

class DashboardDemo extends Component
{
    use WithPagination;

    public $search = '';
    
    public function render()
    {
        $allData = [
            ['id' => 1, 'name' => 'Andi Pratama', 'email' => 'andi@example.com', 'role' => 'Admin', 'status' => 'Aktif', 'date' => '2024-01-15'],
            ['id' => 2, 'name' => 'Budi Santoso', 'email' => 'budi@example.com', 'role' => 'Editor', 'status' => 'Aktif', 'date' => '2024-02-20'],
            ['id' => 3, 'name' => 'Cindy Wijaya', 'email' => 'cindy@example.com', 'role' => 'Viewer', 'status' => 'Nonaktif', 'date' => '2024-03-10'],
            ['id' => 4, 'name' => 'Dedi Kurniawan', 'email' => 'dedi@example.com', 'role' => 'Editor', 'status' => 'Aktif', 'date' => '2024-04-05'],
            ['id' => 5, 'name' => 'Eka Putri', 'email' => 'eka@example.com', 'role' => 'Admin', 'status' => 'Pending', 'date' => '2024-05-18'],
            ['id' => 6, 'name' => 'Fajar Gumilang', 'email' => 'fajar@example.com', 'role' => 'Viewer', 'status' => 'Aktif', 'date' => '2024-06-22'],
            ['id' => 7, 'name' => 'Gita Anggraini', 'email' => 'gita@example.com', 'role' => 'Editor', 'status' => 'Nonaktif', 'date' => '2024-07-14'],
        ];

        $filteredData = array_filter($allData, function($item) {
            return empty($this->search) || 
                   str_contains(strtolower($item['name']), strtolower($this->search)) ||
                   str_contains(strtolower($item['email']), strtolower($this->search));
        });

        return view('livewire.admin-demo.dashboard-demo', [
            'users' => array_slice($filteredData, 0, 5),
            'totalCount' => count($filteredData)
        ])->layout('components.layouts.admin-new');
    }
}
