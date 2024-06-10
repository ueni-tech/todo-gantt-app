<?php

namespace App\Livewire;

use Livewire\Component;

class EditProject extends Component
{
    public $project;
    public $editing = false;
    public $name;

    public function mount($project)
    {
        $this->project = $project;
        $this->name = $project->name;
    }

    public function toggleEditing()
    {
        $this->editing = !$this->editing;
        $this->name = $this->project->name;
        // if($this->editing){
        //     $this->dispatch('focus-input');
        // }
    }

    public function render()
    {
        return view('livewire.edit-project');
    }

    public function rendered()
    {
        if($this->editing){
            $this->dispatch('focus-input');
        }
    }
}
