<?php

namespace App\Livewire\Modals;

use Livewire\Component;
use Livewire\WithFileUploads;

class TeamStore extends Component
{
  use WithFileUploads;
  
  #[validate]
  public $team_name = '';
  public $team_image_name;

  public function rules()
  {
    return [
      'team_name' => ['required', 'string', 'max:255', 'unique:teams,name'],
      'team_image_name' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
    ];
  }

  public function updatedTeamName()
  {
    $this->validateOnly('team_name');
  }

  public function updatedTeamImageName()
  {
    $this->validateOnly('team_image_name');
  }

  public function resetModal()
  {
    $this->resetErrorBag();
    $this->resetValidation();
    $this->reset();
  }

  public function render()
  {
    return view('livewire.modals.team-store');
  }
}
