<?php

namespace App\Livewire;

use Livewire\Component;

class Task extends Component
{
    public $task;
    public $showModal = false;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function toggleTaskEditModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function render()
    {
        return view('livewire.task');
    }
}
