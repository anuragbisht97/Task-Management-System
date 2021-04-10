@extends('dashboard')

@section('meta')

<title>Index</title>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<meta name="_token" content="{{ csrf_token() }}">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

@endsection

@section('content')

<div  class="mr-96 mb-auto ml-24">
	<h1 class="text-2xl font-black ml-auto mr-auto"><b>Projects</b></h1>
	<div class="mb-auto flex">
		<div class="box-content h-auto w-96 p-4 border-4 bg-yellow-400 m4 rounded-xl">
			<h6 class="font-black"><b>Pending</b></h6>
			<ol id="pro_p">
				<li>

				</li>
			</ol>
		</div>
		<div class="box-content h-auto w-96 p-4 border-4 bg-green-400 m4 rounded-xl">
			<h6 class="font-black"><b>Completed</b></h6>
			<ol id="pro_c">
				<li>

				</li>
			</ol>
		</div>
	</div>
	<br>
	<h1 class="text-2xl font-black"><b>Tasks</b></h1>
	<div class="mb-auto flex">
		<div class="box-content h-auto w-96 p-4 border-4 bg-yellow-400 m4 rounded-xl">
			<h6 class="font-black"><b>Pending</b></h6>
			<ol id="tsk_p">
				<li>

				</li>
			</ol>
		</div>
		<div class="box-content h-auto w-96 p-4 border-4 bg-green-400 m4 rounded-xl">
			<h6 class="font-black"><b>Completed</b></h6>
			<ol id="tsk_c">
				<li>

				</li>
			</ol>
		</div>

		<script type='text/javascript'>

			getprojectdash();

			function getprojectdash(){
				$.ajaxSetup({
					headers: {
						"Content-Type": "application/json",
						"Accept": "application/json",
						"X-Requested-With": "XMLHttpRequest",
						"X-CSRF-Token": $('input[name="_token"]').val()
					}
				});
				$.ajax({
					url: '/getprojectdash',
					type: 'GET',
					success: function(projects){
						console.log(projects);
						if(projects[0] != null){
							$("#pro_p li").empty();
							$("#pro_p li").append(projects[0]);
						}
						if(projects[1] != null){
							$("#pro_c li").empty();
							$("#pro_c li").append(projects[1]);
						}
					}
				});
			}

			gettaskdash();

			function gettaskdash(){
				$.ajaxSetup({
					headers: {
						"Content-Type": "application/json",
						"Accept": "application/json",
						"X-Requested-With": "XMLHttpRequest",
						"X-CSRF-Token": $('input[name="_token"]').val()
					}
				});
				$.ajax({
					url: '/gettaskdash',
					type: 'GET',
					success: function(tasks){
						console.log(tasks);
						if(tasks[0] != null){
							$("#tsk_p li").empty();
							$("#tsk_p li").append(tasks[0]);
						}
						if(tasks[1] != null){
							$("#tsk_c li").empty();
							$("#tsk_c li").append(tasks[1]);
						}
					}
				});
			}

		</script>

		@endsection
