<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        // $this->validate([
        //     'password' => ['required', 'string', 'current_password'],
        // ]);

        tap(Auth::user(), $logout(...))->delete();

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
</section>
