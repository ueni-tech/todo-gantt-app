<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Carbon\Carbon;

class StoreTask extends Component
{
  public $project;
  public $showModal = false;

  #[validate]
  public $task_name = '';
  public $note = '';
  public $start_date = '';
  public $end_date = '';

  public function rules()
  {
    return [
      'task_name' => ['required', 'string', 'max:255'],
      'note' => ['nullable', 'string'],
      'start_date' => ['required', 'date'],
      'end_date' => ['required', 'date', 'after_or_equal:start_date'],
    ];
  }

  public function mount(Project $project)
  {
    $this->project = $project;
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

  public function toggleTaskStoreModal()
  {
    $this->showModal = !$this->showModal;
    if($this->showModal)
    {
      $this->setToday();
    }
    else
    {
      $this->resetModal();
    }
  }

  private function setToday()
  {
    $this->start_date = Carbon::today()->format('Y-m-d');
    $this->end_date = Carbon::today()->format('Y-m-d');
  }

  public function resetModal()
  {
    $this->resetErrorBag();
    $this->resetValidation();
    $this->reset('task_name', 'note', 'start_date', 'end_date');
  }

  public function render()
  {
    return view('livewire.store-task');
  }
}
