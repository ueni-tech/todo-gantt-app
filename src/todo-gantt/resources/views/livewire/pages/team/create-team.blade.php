<div>
    <div class="flex flex-col">
        <form action="{{route('teams.store')}}" method="post">
            @csrf
            <div class="flex flex-col">
                <label for="task-name">チーム名</label>
                <input type="text" name="name">
                <button type="submit" class="bg-primary-500 text-white text-sm mt-2 p-1 rounded self-end">作成</button>
            </div>
        </form>
    </div>
</div>
