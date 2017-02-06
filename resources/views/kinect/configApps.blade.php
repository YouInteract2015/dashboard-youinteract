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
		<i class="list layout icon"></i> Generic Config #{{ $config->id }}
	</h3>

	<br />

	<h3>Items of this configuration</h3>
	<table class="ui black table">
		<thead>
			<tr>
				<th><center>ID</center></th>
				<th>App</th>
				<th><center>Preview</center></th>
				<th><center>Remove</center></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($currentApps as $currentApp)
			<tr>
				<td><center>{{ $currentApp->id }}<center></td>
				<td><b>{{ $currentApp->title }}</b>{!! empty($currentItem->description) ? "" : "<br />" . $currentItem->description !!}</td>
				<td><center><img src={{ "/images/apps/" . $currentApp->preview }} class="ui small image"></center></td>
				<td>
					<center>
						<form class="ui form" method="POST" action="/admin/kinect/configs/removeApp">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" value="{{ $currentApp->configItemId }}">
							<input type="hidden" name="config" value="{{ $config->id }}">
							<input type="hidden" name="item" value="{{ $currentApp->id }}">
							<button type="submit" class="circular ui icon button red">
								<i class="icon remove circle "></i>
							</button>
						</form>
					</center>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<br />

	<h3>Available Apps: </h3>
	<table class="ui black table">
		<thead>
			<tr>
				<th><center>ID</center></th>
				<th>App</th>
				<th><center>Preview</center></th>
				<th><center>Add</center></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($availableApps as $availableApp)
			<tr>
				<td><center>{{ $availableApp->id }}</center></td>
				<td><b>{{ $availableApp->title }}</b>{!! empty($availableApp->description) ? "" : "<br />" . $availableApp->description !!}</td>
				<td><center><img src={{ "/images/apps/" . $availableApp->preview }} class="ui small image"></center></td>
				<td>
					<center>
						<form class="ui form" method="POST" action="/admin/kinect/configs/addApp">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="config" value="{{ $config->id }}">
							<input type="hidden" name="item" value="{{ $availableApp->id }}">
							<button type="submit" class="circular ui icon button green">
								<i class="icon check circle "></i>
							</button>
						</form>
					</center>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
