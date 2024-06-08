<?php

namespace App\Livewire;

use App\Models\Task as ModelsTask;
use Livewire\Component;

class Task extends Component
{
    public $task;
    public $completed = false;
    public $showModal = false;

    public function mount($task)
    {
        $this->task = $task;
        $this->completed = $task->completed;
    }

    public function toggleCompleted()
    {
        $this->task = ModelsTask::toggleCompleted($this->task);
        $this->completed = $this->task->completed;
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
