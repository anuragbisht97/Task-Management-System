@extends('dashboard')

@section('meta')

<title>Change Password</title>

@endsection

@section('content')

<div class="flex justify-between">

	<h2 class="font-black text-3xl">Change Password.</h2>

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
        <b class="text-xs text-red-500">WARNING : This will change your password right away.</b>
		<form method="post"  action="{{ route('changePassword')}}" class="m-auto">

            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <label for='new_pass' class="font-black">New Password : </label>
            <input name='new_pass' type='text' required='true' class="rounded w-full" placeholder="Require"><br><br>

            <button type='submit' class="font-black h-8 w-20 rounded-md hover:bg-green-500"><b>Update</b></button>
            <button type='reset' class="font-black h-8 w-20 rounded-md hover:bg-yellow-400"><b>Reset</b></button>
        </form>
    </div>
</div>

@endsection
