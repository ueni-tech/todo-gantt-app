<?php

namespace App\Livewire\Modals;

use Livewire\Component;

class TeamStore extends Component
{
  #[validate]
  public $team_name = '';

  public function rules()
  {
    return [
      'team_name' => ['required', 'string', 'max:255', 'unique:teams,name'],
    ];
  }

  public function updatedTeamName()
  {
    $this->validateOnly('team_name');
  }

  public function render()
  {
    return view('livewire.modals.team-store');
  }
}
