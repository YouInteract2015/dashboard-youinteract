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
			Item added with success
		</div>
		<p>{{ Session::get('success') }}</p>
	</div>
	@endif
	<h3 class="ui inverted white block header">
			<i class="list layout icon"></i> List of available Configs
	</h3>
	<table class="ui black table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th><center>Template</center></th>
				<th><center>Preview</center></th>
				<th><center>Scheduler</center></th>
				<th><center>Actions</center></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($configs as $config)
			<tr>
				<td>{{ $config->id }}</td>
				<td><b>{{ $config->title }}</b>{!! empty($config->description) ? "" : "<br />" . $config->description !!}</td>
				<td><center>{{ $config->templateTitle }}</center></td>
				<td><center><img src={{ "/images/themes/" . $config->templatePreview }} class="ui small image"></center></td>
				<td><center>{{ $config->schedulerTitle }}</center></td>
				<td>
					<center>
						<a class="ui vertical animated button" href={{ "/admin/kinect/configs/" . $config->id . "/apps" }}><div class="hidden content">Apps</div><div class="visible content"><i class="cubes icon"></i></div></a>
						<a class="ui vertical animated button" href="#"><div class="hidden content">Edit</div><div class="visible content"><i class="edit icon"></i></div></a>
						<a class="ui vertical animated button" href="#"><div class="hidden content">Remove</div><div class="visible content"><i class="remove icon"></i></div></a>
					</center>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<br />

	<h3 class="ui inverted white block header">Add Config</h3>
	<form class="ui form" method="POST" action="/admin/kinect/configs/add" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="field">
			<label>Title:</label> <input name="configTitle" id="configTitle" type="text">
		</div>
		<div class="field">
			<label>Description:</label> <input name="configDescription" id="configDescription" type="text">
		</div>
		<div class="field">
			<label>Theme:</label>
			<div class="ui selection dropdown">
				<input name="template" type="hidden">
				<div class="default text">Choose</div>
				<i class="dropdown icon"></i>
				<div class="menu">
					@foreach($templates as $template)
					<div class="item" data-value={{ $template->id }}>{{ $template->id }} - {{ $template->title }}</div>
					@endforeach
				</div>
			</div>
		</div>
		<div class="field">
			<label>Scheduler:</label>
			<div class="ui selection dropdown">
				<input name="scheduler" type="hidden">
				<div class="default text">Choose</div>
				<i class="dropdown icon"></i>
				<div class="menu">
					@foreach($schedulers as $scheduler)
					<div class="item" data-value={{ $scheduler->id }}>{{ $scheduler->id }} - {{ $scheduler->title }}</div>
					@endforeach
				</div>
			</div>
		</div>
		<button type="submit" class="ui red button">Add</button>
	</form>

</div>
@endsection
