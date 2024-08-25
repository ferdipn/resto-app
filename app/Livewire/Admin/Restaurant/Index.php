<?php

namespace App\Livewire\Admin\Restaurant;

use Livewire\Component;
// use Livewire\WithPagination;

class Index extends Component
{
    // use WithPagination;

    public $isModalOpen = false;
    public $itemId;

    protected $listeners = ['openModal', 'closeModal', 'itemSaved', 'itemDeleted'];

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function itemSaved()
    {
        $this->closeModal();
        session()->flash('message', 'Data saved successfully.');
    }

    public function itemDeleted()
    {
        session()->flash('message', 'Data deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.restaurant.index');
    }
}
