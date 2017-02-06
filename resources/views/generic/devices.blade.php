@extends('main')

@section('content')
<div class="fourteen wide column">
	@if (count($errors) > 0)
	<div class="ui error message">
		<i class="close icon"></i>
		<div class="header">
			There was some errors with your submission
		</div>
		<ul class="list">
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	@if(Session::has('error'))
	<div class="ui error message">
		<i class="close icon"></i>
		<div class="header">
			There was some errors with your submission
		</div>
		<p>{{ Session::get('error') }}</p>
	</div>
	@endif
	@if(Session::has('success'))
	<div class="ui positive message">
		<i class="close icon"></i>
		<div class="header">
			Success
		</div>
		<p>{{ Session::get('success') }}</p>
	</div>
	@endif
	<h3 class="ui inverted white block header">
			<i class="list layout icon"></i> List of Generic Devices
	</h3>
	<table class="ui black table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th><center>Localization</center></th>
				<th><center>IP</center></th>
				<th><center>Config</center></th>
				<th><center>Preview</center></th>
				<th><center>Actions</center></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($devices as $device)
			<tr>
				<td>{{ $device->id }}</td>
				<td><b>{{ $device->title }}</b>{!! empty($device->description) ? "" : "<br />" . $device->description !!}</td>
				<td><center>{{ $device->location }}</center></td>
				<td><center>{{ $device->ip }}</center></td>
				<td><center>{{ $device->configTitle }}</center></td>
				<td><center><img src={{ "/images/templates/" . $device->templatePreview }} class="ui small image"></center></td>
				<td>
					<center>
						<a class="ui vertical animated button" href="#"><div class="hidden content">Edit</div><div class="visible content"><i class="edit icon"></i></div></a>
						<a class="ui vertical animated button" href="#"><div class="hidden content">Remove</div><div class="visible content"><i class="remove icon"></i></div></a>
					</center>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
