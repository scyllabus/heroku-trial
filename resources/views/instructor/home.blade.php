@extends('layouts.app')

@section('content')
<div class="container">
	<!-- PROFILE SECTION -->
	<section>
		@include('includes.profile')
	</section>
	
	<!-- NOTIFICATION SECTION -->
	<section>
		@include('includes.notifications')
	</section>

	
</div>
@endsection