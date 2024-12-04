<!DOCTYPE html>
<html>
<head>
    <title>Task Assignment</title>
</head>
<body>
    <p>Hi {{ $assignedUser->name }},</p>
    <p>You have been assigned a new task by {{ $user->name }}:</p>

    <h3>Task Details:</h3>
    <ul>
        <li><strong>Title:</strong> {{ $task->title }}</li>
        <li><strong>Description:</strong> {{ $task->description }}</li>
        <li><strong>Status:</strong> {{ ucfirst($task->status) }}</li>
        <li><strong>Priority:</strong> {{ ucfirst($task->priority) }}</li>
        <li><strong>Due Date:</strong> {{ $task->due_date }}</li>
    </ul>

    @if(/* $task->attachments->isNotEmpty() */true)
        <h4>Attachments:</h4>
        <ul>
            @foreach($task->attachments as $attachment)
                <li>{{ $attachment->file_name }}</li>
            @endforeach
        </ul>
    @endif

    <p>Please log in to the task management system for more details.</p>

    <p>Regards,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>
