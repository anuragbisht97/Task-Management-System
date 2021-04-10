@extends('dashboard')

@section('meta')

<title>Index</title>
<meta name="_token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

@endsection

@section('content')

<div class="flex justify-between mt-5 ml-5 mr-5 px-5">

	<div>

		<h1 class="text-xs text-grey-500"><b>You have registered successfully.</b><br></h1>
		<h1 class="text-xl text-red-500"><b>NOTE : Contact your HR for account activation.</b><br></h1>
		<h1 class="text-xs text-grey-500"><b>Thank you.</b><br></h1>

	</div>
</div>

@endsection
