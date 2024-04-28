<div>
    <div class="flex flex-col">
        <label for="task-name">タスク名</label>
        <input id="task-name" type="text" wire:model="taskName">
    </div>
    <div class="flex flex-col">
        <label for="task-start-date">開始日</label>
        <input id="task-start-date" type="date" wire:model="taskStartDate">
    </div>
    <div class="flex flex-col">
        <label for="task-end-date">終了日</label>
        <input id="task-end-date" type="date" wire:model="taskEndDate">
    </div>
    <div class="flex flex-col">
        <label for="task-note">メモ</label>
        <textarea id="task-note" wire:model="taskNote"></textarea>
    </div>
</div>
