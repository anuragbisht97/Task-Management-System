@extends('dashboard')

@section('meta')

<title>Update</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

@endsection

@section('content')

<div class="flex justify-between">

	<h2 class="font-black text-3xl">Update task.</h2>

</div><br>

@if ($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li><b>{{ $error }}</b></li>
		@endforeach
	</ul>
</div>
@endif

<div class="mr-96 mb-auto ml-24">
<form method="post"  action="{{ route('tasks.update', $task->id)}}">

	@csrf
	@method('put')
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<label for='project_id' class="font-black">Project Name : </label>
	<select name='project_id' class="rounded w-full">
		<option value="{{ $task->project_id }}">
			@if($task->projectId==null)
			NA[DELETED]
			@else
			{{ $task->projectId->project_name }}
			@endif
		</option>
		@foreach($projects as $project)
		@if ($task->project_id!=$project->id)
		<option value='{{ $project->id }}'>{{ $project->project_name }}</option>
		@endif
		@endforeach
	</select><br><br>

	<label for='task_name' class="font-black">Task Name : </label>
	<input name='task_name' type='text' value="{{$task->task_name}}" required='true' class="rounded w-full" placeholder="Require"><br>

	<input id='chkbx' type="checkbox" name="check_box" onclick="generate(this.form)">
	<b>Check this box if you want auto generated id.</b><br><br>

	<label for='task_id' class="font-black">Task Id : </label>
	<input id="auto_id" name='task_id' type='text' value="{{$task->task_id}}" required='true' class="rounded w-full" placeholder="Require"><br><br>

	<label for='summary' class="font-black">Summary : </label>
	<input name='summary' type='text' value="{{ $task->summary }}" required='true' class="rounded w-full" placeholder="Require"><br><br>

	<label for='description' class="font-black">Discripion : </label>
	<input name='description' type='text' value="{{ $task->description }}" class="rounded w-full"><br><br>

	<label for='assign_to' class="font-black">Assign To : </label>
	<select name='assign_to' class="rounded w-full">
		<option value="{{ $task->assign_to }}">
			@if($task->assignTo==null)
			NA[DELETED]
			@else
			{{ $task->assignTo->name }}
			@endif
		</option>
		@foreach($users as $user)
		@if ($task->assign_to!=$user->id)
		<option value='{{ $user->id }}'>{{ $user->name }}</option>
		@endif
		@endforeach
	</select><br><br>

	<label for='assign_by' class="font-black">Assign By : </label>
	<select name='assign_by' class="rounded w-full">
		<option value="{{ $task->assign_by }}">
			@if($task->assignBy==null)
			NA[DELETED]
			@else
			{{ $task->assignBy->name }}
			@endif
		</option>
		@foreach($users as $user)
		@if ($task->assign_by!=$user->id)
		<option value='{{ $user->id }}'>{{ $user->name }}</option>
		@endif
		@endforeach
	</select><br><br>

	<label for='task_created_by' class="font-black">Created By : </label>
	<select name='task_created_by' class="rounded w-full">
		<option value="{{ $task->task_created_by }}">
			@if($task->taskCreatedBy==null)
			NA[DELETED]
			@else
			{{ $task->taskCreatedBy->name }}
			@endif
		</option>
		@foreach($users as $user)
		@if ($task->task_created_by!=$user->id)
		<option value='{{ $user->id }}'>{{ $user->name }}</option>
		@endif
		@endforeach
	</select><br><br>

    <label for='task_status' class="font-black">Task Status : </label>
    <select name="task_status" class="rounded w-full">
        <option value="{{ $task->task_status }}">
            @if($task->task_status==0)
            Pending
            @else
            Completed
            @endif
        </option>
        @if($task->task_status==0)
        <option value="1">Completed</option>
        @elseif($task->task_status==1)
        <option value="0">Pending</option>
        @endif
    </select><br><br>

	<button type='submit' class="font-black h-8 w-20 rounded-md hover:bg-yellow-400"><b>Update</b></button>

</form>
</div>

<script type="text/javascript">
	var temp = $('#auto_id').val();
	function generate(f) {
		if(f.check_box.checked == true) {
			var str = f.task_name.value;
			var matches = str.match(/\b(\w)/g);
			var acronym = matches.join('');
			acronym = acronym.toUpperCase();
			var str1 = "Task_";
			f.task_id.value = str1.concat(acronym);
		}
		else if(f.check_box.checked == false){
			$('#auto_id').val(temp);
		}
	}
</script>
@endsection
