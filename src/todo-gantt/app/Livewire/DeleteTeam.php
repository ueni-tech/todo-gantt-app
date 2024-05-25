<?php

namespace App\Livewire;

use Livewire\Component;

class DeleteTeam extends Component
{
    public $confirmDeletion = false;
    public $selectedTeam;

    public function mount($selectedTeam)
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
