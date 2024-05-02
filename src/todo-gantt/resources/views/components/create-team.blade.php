<div class="hidden transition" :class="{'hidden': !teamModalOpened}">
        <div @click="toggleTeamModal()" class="fixed top-0 left-0 w-screen h-screen bg-gray-950 opacity-50"></div>
        <div class="bg-gray-100 p-4 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium">チームの作成</h3>
            <button @click="toggleTeamModal()" class="text-lg">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
          <div class="mt-3">
            <livewire:Pages.CreateTeam />
          </div>
        </div>
      </div>
      