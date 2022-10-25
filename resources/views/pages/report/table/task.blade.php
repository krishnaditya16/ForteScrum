@php
$task = DB::table('tasks')->where('id', $time->task_id)->first();
@endphp

{{ $task->title }}