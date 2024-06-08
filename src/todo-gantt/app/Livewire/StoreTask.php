<?php

namespace App\Livewire;

use Livewire\Component;

class StoreTask extends Component
{
    public $project;
    public $showModal = false;

    public function mount($project)
    {
        $this->project = $project;
    }

    public function toggleTaskStoreModal()
    {
        $this->showModal = !$this->showModal;
    }
    
    public function render()
    {
        return view('livewire.store-task');
    }
}
