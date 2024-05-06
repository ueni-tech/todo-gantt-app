<?php

namespace App\Livewire\Pages;

use App\Models\Team;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateTeam extends Component
{
    #[Validate('required|string|max:255|unique:teams,name')] 
    public $name = '';

    public $isButtonDisabled = true;

    protected $messages = [
        'name.required' => 'チーム名は必須です。',
        'name.string' => 'チーム名は文字列で入力してください。',
        'name.max' => 'チーム名は255文字以内で入力してください。',
        'name.unique' => 'そのチーム名は既に使用されています。',
    ];

    public function render()
    {
        return view('livewire.pages.team.create-team');
    }

    public function createTeam()
    {
        $this->validate();

        $team = new Team();
        $team->name = $this->name;
        $team->save();
        $this->reset('name');

        // ユーザーにチームを紐付ける
        $team->users()->attach(auth()->user());
    }

    public function updatedName($value)
    {
        // 全角スペースだけの入力を許可しない
        $trimmedValue = preg_replace('/\A\s*\z/u', '', $value);
        $this->isButtonDisabled = $trimmedValue === '';
    }
}
