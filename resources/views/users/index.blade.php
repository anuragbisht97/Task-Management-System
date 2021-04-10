@extends('dashboard')

@section('meta')

<title>Index</title>
<meta name="_token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

@endsection

@section('content')

<div class="flex justify-between mt-5 mb-5 ml-5 mr-5 px-5">

	<h2 class="text-4xl"><b>User</b></h2>

	<div>
		<form method="post" class="flex space-x-2">

			@csrf
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<input name='search' type='text' required='true' class="rounded w-full" id="search" placeholder="Search Name">
			<a>
				<img src = "images/search.svg" style="width:40px;height:40px;">
			</a>

		</form>
	</div>
</div>

<div class="mt-5 mb-5">
	<table class="shadow-xl bg-black-500 w-full" id="userTable">
		<thead class="font-black bg-blue-100 border text-center">
			<tr>
				<th class="px-10 py-5">#</th>
				<th class="px-10 py-5">
					<b id="default" class="cursor-pointer">NAME</b>
					<div class="flex justify-evenly space-x-2">
						<img src = "images/asc.svg" style="width:40px;height:20px;" id="asc" class="cursor-pointer">
						<img src = "images/des.svg" style="width:40px;height:20px;" id="des" class="cursor-pointer">
					</div>
				</th>
				<th class="px-8 py-5">PHONE NUMBER</th>
				<th class="px-10 py-5">EMAIL</th>
				<th class="px-10 py-5">DESIGNATION</th>
				<th class="px-8 py-5">ROLE</th>

				<th class="px-10 py-5" id="tableOperations">OPERATIONS</th>

			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>

<script type='text/javascript'>

	getAccountType();

	$(window).on('load', function(){
		var search = "";
		var btn = 0;
		getRecords(search,btn);
	});

	$(document).ready(function(){
		$('#search').on('keyup',function(){
			var search = $('#search').val();
			var btn = 0;
			getRecords(search,btn);
		});
	});

	$(document).on('click','#asc',function(){
		var search = $('#search').val();
		var btn = 1;
		getRecords(search,btn);
	});

	$(document).on('click','#des',function(){
		var search = $('#search').val();
		var btn = -1;
		getRecords(search,btn);
	});

    $(document).on('click','#default',function(){
		var search = $('#search').val();
		var btn = 0;
		getRecords(search,btn);
	});

	$(document).on('click','#del',function(){
		var url = $(this).attr("data-url");
		var del_con = delete_confirm();
		console.log(url);
		if(del_con == true)
		{
			deleteRecords(url);
		}
	});

	function getAccountType(){
		$.ajaxSetup({
			headers: {
				"Content-Type": "application/json",
				"Accept": "application/json",
				"X-Requested-With": "XMLHttpRequest",
				"X-CSRF-Token": $('input[name="_token"]').val()
			}
		});
		$.ajax({
			url: '/type',
			type: 'GET',
			success: function(currentAccountType){

				if(currentAccountType == "local"){
					$("#createUser").remove();
					$("#tableOperations").remove();
				}
			}
		});
	}

	function getRecords(search,btn){
		$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
		$.ajax({
			url: '/searchUser',
			data : {btn : btn, search: search},
			success: function(output){
				if(output != null){
					$("#userTable tbody").empty();
					$("#userTable tbody").html(output);
				}
				else{
					var tr_str = "<tr>" +
						"<td>No record found.</td>" +
						"</tr>";
						$("#userTable tbody").html(tr_str);
					}
				}
			});
		}

		function delete_confirm(){
			var option = confirm("Do you really want to delete this record.");
			if(option == true){
				return true;
			}else{
				return false;
			}
		}

		function deleteRecords(url){
			$.ajaxSetup({
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-Token": $('input[name="_token"]').val()
				}
			});
			$.ajax({
				url: url,
				type: 'DELETE',
				success: function(){
					window.location.reload();
				}
			});
		}

	</script>

	@endsection
