<?php

namespace App\Livewire\Modals;

use Livewire\Component;

class ProjectStore extends Component
{
  #[validate]
  public $project_name = '';

  public function rules()
  {
    return [
      'project_name' => ['required', 'string', 'max:255'],
    ];
  }

  public function updatedprojectName()
  {
    $this->validateOnly('project_name');
  }
  public function render()
  {
    return view('livewire.modals.project-store');
  }
}
