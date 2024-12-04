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
                                @foreach(['opened', 'in_progress', 'completed' , 'closed'] as $status)
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
            <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
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
                            <a href="{{ asset('storage/' .$attachment->file_path) }}" target="_blank" >
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

    