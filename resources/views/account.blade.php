@extends('layouts.app')

@section('content')
	<div class="container">
		<h3>Account Settings</h3>
		<form action="">
			{{ csrf_field()	 }}
			{{ method_field('PATCH') }}
		</form>
	</div>
@endsection