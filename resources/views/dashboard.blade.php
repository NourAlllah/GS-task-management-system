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
            <form class="search-filter-form" method="GET" action="{{ route('tasks.index') }}">
                <div class="form-group">
                    <input type="text" name="search" placeholder="Search tasks..." value="{{ request('search') }}">
                </div>
                <div class="form-group">
                    <select name="status">
                        <option value="">All Statuses</option>
                        <option value="open" {{ request('status') == 'opened' ? 'selected' : '' }}>Opened</option>
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
            </form>
        </div>

        <!-- Content Categories -->
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

        <!-- Tasks Wrapper -->
        <div class="tasks-wrapper">
            <!-- Assigned Tasks -->
            <div id="assigned-tasks" class="task-list">
                @foreach ($assignedTasks as $task)
                <div class="task">
                    <span class="label-text">{{ $task->title }}</span>
                    <a href="{{ route('tasks.show', $task->id) }}" target="_blank" class="view_details_btn">View Details</a>
                    <span class="tag {{ $task->status }}">{{ ucfirst($task->status) }}</span>
                </div>
                @endforeach
            </div>

            <!-- Created Tasks -->
            <div id="created-tasks" class="task-list" style="display: none;">
                @foreach ($myTasks as $task)
                <div class="task">
                    <span class="label-text">{{ $task->title }}</span>
                    <a href="{{ route('tasks.show', $task->id) }}" target="_blank" class="view_details_btn">View Details</a>
                    <span class="tag {{ $task->status }}">{{ ucfirst($task->status) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>

        function showTasks(type) {
            // Task sections
            const assignedTab = document.getElementById('assigned-tasks');
            const createdTab = document.getElementById('created-tasks');

            // Label wrappers
            const assignedText = document.getElementById('assigned-tab');
            const createdText = document.getElementById('created-tab');

            if (type === 'assigned') {
                // Show/hide task sections
                assignedTab.style.display = 'block';
                createdTab.style.display = 'none';

                // Toggle active class
                assignedText.classList.add('active');
                createdText.classList.remove('active');
            } else {
                // Show/hide task sections
                assignedTab.style.display = 'none';
                createdTab.style.display = 'block';

                // Toggle active class
                createdText.classList.add('active');
                assignedText.classList.remove('active');
            }
        }

    </script>
</x-app-layout>
