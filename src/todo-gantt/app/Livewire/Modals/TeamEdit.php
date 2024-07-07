<?php

namespace App\Livewire\Modals;

use App\Models\User;
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

  public function resetModal()
  {
    $this->team_name = $this->selectedTeam->name;
    $this->isTeamNameChanged = false;
    $this->resetErrorBag();
    $this->resetValidation();
  }

  public function removeUserFromTeam($user_id)
  {
    $this->selectedTeam->users()->detach($user_id);

    $user = User::find($user_id);
    if ($user->teams->count() > 0) {
      User::changeCurrentTeam($user, $user->teams->first());
    } else {
      $user->selected_team_id = null;
      $user->save();
    }

    if($this->selectedTeam->users->count() === 0){
      $this->selectedTeam->delete();
    }
  }

  public function render()
  {
    return view('livewire.modals.team-edit');
  }
}
