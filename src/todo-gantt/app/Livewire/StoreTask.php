<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class StoreTask extends Component
{
    public $project;
    public $showModal = false;

    public function mount(Project $project)
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
