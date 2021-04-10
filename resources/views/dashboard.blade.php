<x-app-layout>

	<!DOCTYPE html>
	<html lang="en">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		@yield('meta')

		<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

	</head>

	<body class="bg-blue-200">

		<x-slot name="header">
		</x-slot>

		<div class="flex">
			<div class="bg-blue-200 w-min h-screen fixed mt-8">
				<h1 class="font-black text-5xl ml-5 mt-5 mr-5">Manager</h1>

				<ul class="mt-10">

					<li><a class="inline-block w-full py-4 px-6 font-black hover:bg-blue-400" href="{{ route('projects.index') }}">Projects</a></li>
					<li><a class="inline-block w-full py-4 px-6 font-black hover:bg-blue-400" href="{{ route('tasks.index') }}">Tasks</a></li>
					<li><a class="inline-block w-full py-4 px-6 font-black hover:bg-blue-400" href="{{ route('users.index') }}">Users</a></li>

				</ul>
			</div>
		</div>

		<div class="mt-36 mr-8 mb-auto ml-72">
			@yield('content')
		</div>

	</body>
	</html>

</x-app-layout>
