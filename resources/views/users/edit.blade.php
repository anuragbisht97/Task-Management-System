@extends('dashboard')

@section('meta')

<title>Update</title>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>

@endsection

@section('content')

<div class="flex justify-between">

	<h2 class="font-black text-3xl">Update user.</h2>

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
	<form method="post"  action="{{ route('users.update', $user->id)}}">

		@csrf
		@method('put')
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<label for='name' class="font-black">User Name : </label>
		<input name='name' type='text' value="{{ $user->name }}" required='true' class="rounded w-full" placeholder="Require"><br>

		<input id='chkbx' type="checkbox" name="check_box" onclick="generate(this.form)">
		<b>Check this box if you want auto generated id.</b><br><br>

		<label for='user_id' class="font-black">User Id : </label>
		<input id="auto_id" name='user_id' type='text' value="{{ $user->user_id }}" required='true' class="rounded w-full" placeholder="Require"><br><br>

		<label for='phone_number' class="font-black">Phone Number : </label>
		<input name='phone_number' type='text' value="{{ $user->phone_number }}" class="rounded w-full" placeholder="Require"><br><br>

		<label for='email' class="font-black">Email : </label>
		<input name='email' type='text' value="{{ $user->email }}" required='true' class="rounded w-full" placeholder="Require"><br><br>

		<label for='address' class="font-black">Address : </label>
		<input name='address' type='text' value="{{ $user->address }}" required='true' class="rounded w-full" placeholder="Require"><br><br>

		<label for='designation' class="font-black">Designation : </label>
		<input name='designation' type='text' value="{{ $user->designation }}" required='true' class="rounded w-full" placeholder="Require"><br><br>

		<label for='role' class="font-black">Role : </label>
		<input name='role' type='text' value="{{ $user->role }}" required='true' class="rounded w-full" readonly placeholder="Require"><br>

		<div class="flex justify-evenly font-black">
			<label for="role">Change Role :&nbsp;</label>
			<span>
				<input type="radio" id="admin" name="role" value="admin">
				<label for="admin">&nbsp;Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><br>
			</span>
			<span>
				<input type="radio" id="local" name="role" value="local">
				<label for="local">&nbsp;Local&nbsp;</label><br>
			</span>
		</div><br>

        <label for='user_status' class="font-black">User Status : </label>
        <select name="user_status" class="rounded w-full">
            <option value="{{ $user->user_status }}">
                @if($user->user_status==0)
				Passive
				@else
                Active
				@endif
            </option>
            @if($user->user_status==0)
            <option value="1">Active</option>
            @elseif($user->user_status==1)
            <option value="0">Passive</option>
            @endif
        </select><br><br>

		<button type='submit' class="font-black h-8 w-20 rounded-md hover:bg-yellow-400"><b>Update</b></button>

	</form>
    </div>

	<script type="text/javascript">
		var temp = $('#auto_id').val();
		function generate(f) {
			if(f.check_box.checked == true) {
				var str = f.name.value;
				var matches = str.match(/\b(\w)/g);
				var acronym = matches.join('');
				acronym = acronym.toUpperCase();
				var str1 = "User_";
				f.user_id.value = str1.concat(acronym);
			}
			else if(f.check_box.checked == false){
				$('#auto_id').val(temp);
			}
		}
	</script>
</div>

@endsection
