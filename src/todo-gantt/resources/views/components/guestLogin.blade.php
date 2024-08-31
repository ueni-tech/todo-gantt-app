<div class="bg-gray-100 rounded-lg p-4">
  <p class="text-sm">以下はポートフォリオ確認用のゲストログインフォームです</p>
  <p class="text-sm">共有済みのゲストユーザー名とゲストパスワードを入力してログインしてください</p>
  <form action="{{ route('login-as-guest') }}" method="POST" class="mt-4 space-y-4 w-full max-w-md">
    @csrf
    <div>
      <x-input-label for="guest_username" :value="__('ゲストユーザー名')" />
      <x-text-input id="guest_username" class="block mt-1 w-full" type="text" name="guest_username" required autofocus />
    </div>
    
    <div class="mt-4">
      <x-input-label for="guest_password" :value="__('ゲストパスワード')" />
      <x-text-input id="guest_password" class="block mt-1 w-full" type="password" name="guest_password" required />
    </div>
    <x-input-error :messages="$errors->get('guest_username')" class="mt-2" />
    <div class="flex items-center justify-end mt-4">
      <x-primary-button class="ml-3">
        {{ __('ゲストとしてログイン') }}
      </x-primary-button>
    </div>
  </form>
</div>
