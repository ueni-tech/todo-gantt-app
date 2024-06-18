<?php

namespace App\Livewire\Modals;

use Livewire\Component;

class TeamEdit extends Component
{
  public $selectedTeam;

  public $team_name = '';

  public $isTeamNameChanged = false;

  public function mount($selectedTeam)
  {
    $this->selectedTeam = $selectedTeam;
    $this->team_name = $selectedTeam->name;
  }

  public function rules()
  {
    $rules = [
      'team_name' => ['required', 'string', 'max:255'],
    ];

    // チーム名が変更された場合のみ 'unique' ルールを追加
    if ($this->isTeamNameChanged()) {
      $rules['team_name'][] = 'unique:teams,name';
    }

    return $rules;
  }

  public function updatedTeamName()
  {
    $this->validateOnly('team_name');
    $this->isTeamNameChanged = $this->isTeamNameChanged();
  }

  public function isTeamNameChanged()
  {
    return $this->selectedTeam->name !== $this->team_name;
  }

  public function render()
  {
    return view('livewire.modals.team-edit');
  }
}
