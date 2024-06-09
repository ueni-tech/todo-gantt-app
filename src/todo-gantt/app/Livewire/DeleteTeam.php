<?php

namespace App\Livewire;

use App\Models\Team;
use Livewire\Component;

class DeleteTeam extends Component
{
    public $confirmDeletion = false;
    public $selectedTeam;

    public function mount(Team $selectedTeam)
    {
        $this->selectedTeam = $selectedTeam;
    }

    public function toggleConfirmDeletion()
    {
        $this->confirmDeletion = !$this->confirmDeletion;
    }

    public function render()
    {
        return view('livewire.delete-team');
    }
}
