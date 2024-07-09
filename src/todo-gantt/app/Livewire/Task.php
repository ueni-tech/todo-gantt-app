<?php

namespace App\Livewire;

use App\Models\Task as ModelsTask;
use Livewire\Component;

class Task extends Component
{
  public $task;

  #[validate]
  public $task_name;
  public $note;
  public $start_date;
  public $end_date;

  public $completed = false;
  public $showEditModal = false;
  public $showDeleteModal = false;

  public function rules()
  {
    return [
      'task_name' => ['required', 'string', 'max:255'],
      'note' => ['nullable', 'string'],
      'start_date' => ['nullable', 'date'],
      'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
    ];
  }

  public function mount(ModelsTask $task)
  {
    $this->task = $task;
    $this->task_name = $task->name;
    $this->note = $task->note;
    $this->start_date = $task->start_date;
    $this->end_date = $task->end_date;
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
    if(!$this->showEditModal)
    {
      $this->resetModal();
    }
  }

  public function toggleTaskDeleteModal()
  {
    $this->showDeleteModal = !$this->showDeleteModal;
  }

  public function updatedtaskName()
  {
    $this->validateOnly('task_name');
  }

  public function updatedNote()
  {
    $this->validateOnly('note');
  }

  public function updatedStartDate()
  {
    $this->validateOnly('start_date');
    $this->validateOnly('end_date');
  }

  public function updatedEndDate()
  {
    $this->validateOnly('end_date');
  }

  public function resetModal()
  {
    $this->resetErrorBag();
    $this->resetValidation();
    $this->task_name = $this->task->name;
    $this->note = $this->task->note;
    $this->start_date = $this->task->start_date;
    $this->end_date = $this->task->end_date;
  }

  public function render()
  {
    return view('livewire.task');
  }
}
