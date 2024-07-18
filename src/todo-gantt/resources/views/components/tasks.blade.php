<div class="max-h-[calc(100vh-250px)] overflow-y-auto hidden-scrollbar hidden-scrollbar::-webkit-scrollbar">
    <ul class="flex flex-col gap-3 hidden-scrollbar hidden-scrollbar::-webkit-scrollbar">
        @foreach($tasks as $task)
        <livewire:task :task="$task" :key="$task->id" />
        @endforeach
        <li>
            <div class="flex justify-between items-baseline">
                <livewire:store-task :project="$project" />
                <div class="flex justify-end items-baseline gap-2">
                    <form action="{{route('projects.update-status', $project)}}" method="POST" id="statusForm">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{$project->status == 'incomplete' ? 'completed' : 'incomplete'}}">
                        <button type="submit" class="text-xs text-white bg-primary-500 hover:bg-primary-600 p-1 rounded-md shadow-md">
                            {{$project->status == 'incomplete' ? '完了' : '未完'}}
                        </button>
                    </form>
                    @if($project->status === 'incomplete')
                    <form action="{{route('projects.update-status', $project)}}" method="POST" id="statusForm">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="pending">
                        <button type="submit" class="text-xs text-white bg-gray-500 hover:bg-gray-600 p-1 rounded-md shadow-md">
                            保留
                        </button>
                    </form>
                    @endif
                    <livewire:delete-project :project="$project" />
                </div>
            </div>
        </li>
    </ul>
</div>
