<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\Team;

new class extends Component
{
    public string $password = '';
    public bool $isGuestUser = false;

    public function mount()
    {
        $this->isGuestUser = Auth::user()->name === 'guestuser';
    }

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        if ($this->isGuestUser) {
            return;
        }

        // $this->validate([
        //     'password' => ['required', 'string', 'current_password'],
        // ]);

        tap(Auth::user(), $logout(...))->delete();
        Team::checkAllTeamsHasUser();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            アカウントの削除
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            アカウントが削除されると、そのデータはすべて削除されます。
        </p>
    </header>

    @if ($isGuestUser)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2" role="alert">
            <p class="font-bold">注意</p>
            <p>ゲストユーザーアカウントは削除できません。</p>
        </div>
    @else
        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">アカウントを削除する</x-danger-button>

        <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
            <form wire:submit="deleteUser" class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    本当にアカウントを削除してよろしいですか？
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    アカウントが削除されると、そのデータはすべて削除されます。
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        キャンセル
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        アカウント削除
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    @endif
</section>
