<x-app-layout>
    <div class="page-content">
        <div class="header">
            <div> Tasks </div> 
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
        <div class="content-categories">
            <div class="label-wrapper">
                <input class="nav-item" name="nav" type="radio" id="opt-1">
                <label class="category" for="opt-1">Assigned Tasks</label>
            </div>
            <div class="label-wrapper">
                <input class="nav-item" name="nav" type="radio" id="opt-2" checked>
                <label class="category" for="opt-2">Created Tasks</label>
            </div>
        </div>
        <div class="tasks-wrapper">
            <div class="task">
                <input class="task-item" name="task" type="checkbox" id="item-1" checked>
                <label for="item-1">
                    <span class="label-text">Dashboard Design Implementation</span>
                </label>
                <span class="tag approved">Approved</span>
            </div>
            <div class="task">
                <label for="item-2">
                    <span class="label-text">Create a userflow</span>
                </label>
                <span class="tag progress">In Progress</span>
            </div>
            <div class="task">
                <label for="item-3">
                    <span class="label-text">Application Implementation</span>
                </label>
                <span class="tag review">In Review</span>
            </div>
        </div>
    </div>
</x-app-layout>
