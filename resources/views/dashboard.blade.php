<x-app-layout>
    <div class="page-content">
        <div class="header">
            <div>Tasks</div> 
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
                    <span class="tag {{ $task->status }}">{{ ucfirst($task->status) }}</span>
                </div>
                @endforeach
            </div>

            <!-- Created Tasks -->
            <div id="created-tasks" class="task-list" style="display: none;">
                @foreach ($myTasks as $task)
                <div class="task">
                    <span class="label-text">{{ $task->title }}</span>
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
