@extends('dashboard')

@section('meta')

<title>Create</title>
<meta name="_token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

@endsection

@section('content')

<div class="flex justify-between">

	<h2 class="font-black text-3xl">Create project.</h2>

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
	<form method="post"  action="{{ route('projects.store')}}" class="m-auto">

		@csrf
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<label for='project_name' class="font-black">Project Name : </label>
		<input name='project_name' type='text' required='true' class="rounded w-full" placeholder="Require"><br>

		<input id='chkbx' type="checkbox" name="check_box" onclick="generate(this.form)">
		<b>Check this box if you want auto generated id.</b><br><br>

		<label for='project_id' class="font-black">Project Id : </label>
		<input id="auto_id" name='project_id' type='text' required='true' class="rounded w-full" placeholder="Require"><br><br>

		<label for='summary' class="font-black">Summary : </label>
		<input name='summary' type='text' class="rounded w-full" placeholder="Require"><br><br>

		<label for='description' class="font-black">Description : </label>
		<input name='description' type='text' class="rounded w-full"><br><br>

		<input id="project_created_by" name='project_created_by' type='hidden' value='' required='true' class="rounded w-full"><br>

		<button type='submit' class="font-black h-8 w-20 rounded-md hover:bg-green-500"><b>Create</b></button>
		<button type='reset' class="font-black h-8 w-20 rounded-md hover:bg-yellow-400"><b>Reset</b></button>
	</form>
    </div>
	<script>
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

		$(window).on('load', function(){
			getAccountName();
		});

		function getAccountName(){
			$.ajaxSetup({
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-Token": $('input[name="_token"]').val()
				}
			});
			$.ajax({
				url: '/name',
				type: 'GET',
				success: function(result){
					$("#project_created_by").val(result);
				}
			});
		}

	</script>
</div>

@endsection
