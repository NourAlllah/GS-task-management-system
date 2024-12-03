<x-app-layout>

    <div class="page-content">
    
        <div class="task-details card">
            <h1 class="task-title">{{ $task->title }}</h1>
            <p><strong>Description:</strong> {{ $task->description }}</p>
            <p><strong>Status:</strong> 
                @if(Auth::id() === $task->assigned_to)
                    <form action="{{ route('tasks.update_status', $task->id) }}" method="POST">
                        @csrf
                        <div class="status-dropdown">
                            <select name="status" class="status-select">
                                @foreach(['open', 'in_progress', 'completed'] as $status)
                                    <option value="{{ $status }}" @if($status === $task->status) disabled selected @endif>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn update-btn">Update</button>
                        </div>
                    </form>
                @else
                    {{ ucfirst($task->status) }}
                @endif
            </p>
            <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
        </div>
    
        <div class="attachments card">
            <h3>Attachments</h3>
            @if($task->attachments->isEmpty())
                <p>No attachments available.</p>
            @else
                <ul>
                    @foreach($task->attachments as $attachment)
                        <li>
                            <a href="{{ asset($attachment->file_path) }}" target="_blank">
                                {{ $attachment->file_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    
        <div class="comments card">
            <h3>Comments</h3>
            @if($task->comments->isEmpty())
                <p>No comments yet.</p>
            @else
                <ul class="comment-list">
                    @foreach($task->comments as $comment)
                        <li class="comment-item">
                            <div class="comment-header">
                                <strong>{{ $comment->user->name }}</strong> 
                                <span class="comment-date">{{ $comment->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                            <p class="comment-text">{{ $comment->comment }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    
        <div class="add-comment card">
            <h3>Add a Comment</h3>
            <form action="{{ route('comments.store', $task->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="comment" class="form-control" rows="4" placeholder="Write your comment here..." required></textarea>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
    
    </div>
    
</x-app-layout>
    
<style>
    .page-content {
        max-width: 800px;
        margin: 20px auto;
        padding: 10px;
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
    }
    .card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .task-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }
    h3 {
        font-size: 1.5rem;
        color: #0056b3;
        margin-bottom: 15px;
    }
    ul {
        padding-left: 20px;
        list-style-type: disc;
    }
    ul.comment-list {
        list-style: none;
        padding: 0;
    }
    .comment-item {
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    .comment-header {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    .comment-text {
        font-size: 1rem;
        color: #555;
        margin: 0;
    }
    .form-group {
        margin-bottom: 15px;
    }
    textarea.form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        resize: vertical;
    }
    textarea.form-control:focus {
        border-color: #007bff;
        outline: none;
    }
    button.btn {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
    }
    button.btn:hover {
        background-color: #0056b3;
    }
    .task-manager{
        overflow-y: scroll;
    }
    .status-dropdown {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .status-select {
        width: auto;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }
    .status-select:focus {
        border-color: #007bff;
        outline: none;
    }
</style>
    