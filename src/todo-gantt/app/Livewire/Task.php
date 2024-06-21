<?php

namespace App\Livewire;

use App\Models\Task as ModelsTask;
use Livewire\Component;

class Task extends Component
{
    public $task;
    public $completed = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    public function mount(ModelsTask $task)
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
        $this->showEditModal = !$this->showEditModal;
    }

    public function toggleTaskDeleteModal()
    {
        $this->showDeleteModal = !$this->showDeleteModal;
    }

    public function render()
    {
        return view('livewire.task');
    }
}
