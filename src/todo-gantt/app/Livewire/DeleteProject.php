<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class DeleteProject extends Component
{
    public $project;
    public $showModal = false;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function confirmDelete()
    {
        $this->showModal = !$this->showModal;
    }

    public function render()
    {
        return view('livewire.delete-project');
    }
}
