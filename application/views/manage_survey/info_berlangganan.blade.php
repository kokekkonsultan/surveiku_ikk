@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')

@endsection

@section('content')

<div class="container">
	<div class="card card-custom card-sticky mt-5" data-aos="fade-up">
		<div class="card-header bg-secondary">
			<div class="card-title">
				{{ $title }}
			</div>
			<div class="card-toolbar">
			</div>
		</div>
		<div class="card-body">

			<table class="table table-bordered">
				<tr>
					<th>Username</th>
					<td>{{ $data_user->username }}</td>
				</tr>
				<tr>
					<th>Email</th>
					<td>{{ $data_user->email }}</td>
				</tr>
				<tr>
					<th>HP</th>
					<td>{{ $data_user->phone }}</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="card card-custom card-sticky mt-5" data-aos="fade-up" data-aos-delay="300">
		<div class="card-header bg-secondary">
			<div class="card-title">
				Data Berlangganan
			</div>
			<div class="card-toolbar">
			</div>
		</div>
		<div class="card-body">
			@php
			echo $table;
			@endphp
		</div>
	</div>
</div>

@endsection

@section('javascript')

@endsection