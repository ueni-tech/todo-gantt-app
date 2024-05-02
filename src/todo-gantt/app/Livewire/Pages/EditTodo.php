<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class EditTodo extends Component
{
    public $taskName;
    public $taskStartDate;
    public $taskEndDate;
    public $taskNote;

    public function render()
    {
        return view('livewire.pages.todo.edit-todo');
    }
}
