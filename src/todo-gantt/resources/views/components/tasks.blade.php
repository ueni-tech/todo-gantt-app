<div class="mt-2 max-h-[calc(100vh-280px)] overflow-y-auto hidden-scrollbar hidden-scrollbar::-webkit-scrollbar">
    <ul class="flex flex-col gap-3 hidden-scrollbar hidden-scrollbar::-webkit-scrollbar">
        @foreach($tasks as $task)
        <livewire:task :task="$task" :key="$task->id" />
        @endforeach
        <li>
            <livewire:store-task :project="$project" />
        </li>
    </ul>
</div>
