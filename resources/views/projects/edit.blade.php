@extends('dashboard')

@section('meta')

<title>Update</title>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>

@endsection

@section('content')

<div class="flex justify-between">

	<h2 class="font-black text-3xl">Update project.</h2>

</div><br>

<div>

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
	<form method="post"  action="{{ route('projects.update', $project->id)}}">

		@csrf
		@method('put')
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<label for='project_name' class="font-black">Project Name : </label>
		<input name='project_name' type='text' value="{{ $project->project_name }}" required='true' class="rounded w-full" placeholder="Require"><br>

		<input id='chkbx' type="checkbox" name="check_box" onclick="generate(this.form)">
		<b>Check this box if you want auto generated id.</b><br><br>

		<label for='project_id' class="font-black">Project Id : </label>
		<input id="auto_id" name='project_id' type='text' value="{{ $project->project_id }}" required='true' class="rounded w-full" placeholder="Require"><br><br>

		<label for='summary' class="font-black">Summary : </label>
		<input name='summary' type='text' value="{{ $project->summary }}" class="rounded w-full" placeholder="Require"><br><br>

		<label for='description' class="font-black">Description : </label>
		<input name='description' type='text' value="{{ $project->description }}" class="rounded w-full"><br><br>

		<label for='project_created_by' class="font-black">Project Created By : </label>
		<select name='project_created_by' class="rounded w-full">
			<option value="{{ $project->project_created_by }}">
				@if($project->projectCreatedBy==null)
				NA[DELETED]
				@else
				{{ $project->projectCreatedBy->name }}
				@endif
			</option>
			@foreach($users as $user)
			@if ($project->project_created_by!=$user->id)
			<option value='{{ $user->id }}'>{{ $user->name }}</option>
			@endif
			@endforeach
		</select><br><br>

        <label for='project_status' class="font-black">Project Status : </label>
        <select name="project_status" class="rounded w-full">
            <option value="{{ $project->project_status }}">
                @if($project->project_status==0)
				Pending
				@else
                Completed
				@endif
            </option>
            @if($project->project_status==0)
            <option value="1">Completed</option>
            @elseif($project->project_status==1)
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
				var str = f.project_name.value;
				var matches = str.match(/\b(\w)/g);
				var acronym = matches.join('');
				acronym = acronym.toUpperCase();
				var str1 = "Project_";
				f.project_id.value = str1.concat(acronym);
			}
			else if(f.check_box.checked == false){
				$('#auto_id').val(temp);
			}
		}
	</script>
</div>

@endsection
