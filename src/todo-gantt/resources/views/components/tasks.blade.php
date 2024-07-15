<div class="h-[calc(100vh-200px)] overflow-y-auto hidden-scrollbar hidden-scrollbar::-webkit-scrollbar">
    <ul class="overflow-y-auto flex flex-col gap-3 hidden-scrollbar hidden-scrollbar::-webkit-scrollbar">
        @foreach($tasks as $task)
        <livewire:task :task="$task" :key="$task->id" />
        @endforeach
        <li>
            <div class="flex justify-between items-center">
                <livewire:store-task :project="$project" />
                <livewire:delete-project :project="$project" />
            </div>
        </li>
    </ul>
</div>
