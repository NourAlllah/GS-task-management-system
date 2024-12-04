<x-app-layout>
    <div class="page-content">
        <div class="header">
            <div>Tasks</div> 
            <div>
                <a href="{{ route('tasks.create.page') }}" class="create_task_btn" target="blank">Create New Task</a>
            </div>
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>

        <div class="search-filter">
            <form class="search-filter-form" method="GET" action="{{ route('dashboard') }}">
                <div class="form-group">
                    <input type="text" name="search" placeholder="Search tasks..." value="{{ request('search') }}">
                </div>
                <div class="form-group">
                    <select name="status">
                        <option value="">All Statuses</option>
                        <option value="opened" {{ request('status') == 'opened' ? 'selected' : '' }}>Opened</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="form-group">
                    <select name="priority">
                        <option value="">All Priorities</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
                <div class="form-group">
                    <select name="assigned_to">
                        <option value="">All Assignees</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn">Filter</button>
                <a href="{{ route('dashboard') }}" class="btn clear-filters">Clear All</a>
            </form>
        </div>

        <div class="content-categories">
            <div class="label-wrapper">
                <label class="category active" id="assigned-tab" onclick="showTasks('assigned')">
                    Assigned Tasks
                </label>
            </div>
            <div class="label-wrapper">
                <label class="category" id="created-tab" onclick="showTasks('created')">
                    Created Tasks
                </label>
            </div>
        </div>

        <div class="tasks-wrapper">
            <div id="assigned-tasks" class="task-list">
                @foreach ($assignedTasks as $task)
                <div class="task">
                    <span class="label-text">{{ $task->title }}</span>
                    <a href="{{ route('tasks.show', $task->id) }}" target="_blank" class="view_details_btn">View Details</a>
                    <span class="priority {{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                    <span class="tag {{ $task->status }}">{{ ucfirst($task->status) }}</span>
                </div>
                @endforeach
            </div>

            <div id="created-tasks" class="task-list" style="display: none;">
                @foreach ($myTasks as $task)
                <div class="task">
                    <span class="label-text">{{ $task->title }}</span>
                    <a href="{{ route('tasks.show', $task->id) }}" target="_blank" class="view_details_btn">View Details</a>
                    <span class="priority {{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                    <span class="tag {{ $task->status }}">{{ ucfirst($task->status) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

 
</x-app-layout>
