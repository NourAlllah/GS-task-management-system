<x-app-layout>
    <div class="page-content">
        <h1  class="header">{{ $task->title }}</h1>
        <p><strong>Description:</strong> {{ $task->description }}</p>
        <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
        <p><strong>Due Date:</strong> {{ $task->due_date}}</p>

        <h3>Attachments</h3>
        @if($task->attachments->isEmpty())
            <p>No attachments available.</p>
        @else
            <ul>
                @foreach($task->attachments as $attachment)
                    <li>
                        <a href="{{ asset( $attachment->file_path) }}" target="_blank">
                            {{ $attachment->file_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <h3>Comments</h3>
        @if($task->comments->isEmpty())
            <p>No comments yet.</p>
        @else
            <ul>
                @foreach($task->comments as $comment)
                    <li>
                        <strong>{{ Auth::user()->name }}:</strong> {{ $comment->comment }}
                    </li>
                @endforeach
            </ul>
        @endif
        {{-- <form action="{{ route('tasks.create') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="date" id="due_date" name="due_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="attachment">Attachment</label>
                <input type="file" id="attachment" name="attachment" class="form-control">
            </div>

            <div class="form-group">
                <label for="assigned_to">Assign To</label>
                <select id="assigned_to" name="assigned_to" class="form-control" required>
                    <option value="" disabled selected>Select a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Create Task</button>
        </form> --}}
    </div>
</x-app-layout>


<style>
.header{
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 12px;
}
.btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    cursor: pointer;
}

.btn:hover {
    background-color: #0056b3;
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
}

</style>
