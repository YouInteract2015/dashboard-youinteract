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
				<th><center>Order</center></th>
				<th><center>ID</center></th>
				<th>Item</th>
				<th><center>Type</center></th>
				<th><center>Preview</center></th>
				<th><center>Remove</center></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($currentItems as $currentItem)
			<tr>
				<td>
					<center>
						@if( $currentItem->priority > 1 )
						<form class="ui form" method="POST" action="/admin/generic/configs/increaseItem">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" value="{{ $currentItem->configItemId }}">
							<input type="hidden" name="config" value="{{ $config->id }}">
							<input type="hidden" name="item" value="{{ $currentItem->id }}">
							<button type="submit" class="circular ui icon button green">
								<i class="icon pointing up "></i>
							</button>
						</form>
						@endif
						@if( $currentItem->priority < count($currentItems) )
						<form class="ui form" method="POST" action="/admin/generic/configs/decreaseItem">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" value="{{ $currentItem->configItemId }}">
							<input type="hidden" name="config" value="{{ $config->id }}">
							<input type="hidden" name="item" value="{{ $currentItem->id }}">
							<button type="submit" class="circular ui icon button red">
								<i class="icon pointing down "></i>
							</button>
						</form>
						@endif
					</center>
				</td>
				<td><center>{{ $currentItem->id }}<center></td>
				<td><b>{{ $currentItem->title }}</b>{!! empty($currentItem->description) ? "" : "<br />" . $currentItem->description !!}</td>
				<td><center>{{ $currentItem->type == 0 ? "Image" : "Youtube" }}</center></td>
				<td><center><img src={{ "/images/items/" . $currentItem->preview }} class="ui small image"></center></td>
				<td>
					<center>
						<form class="ui form" method="POST" action="/admin/generic/configs/removeItem">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" value="{{ $currentItem->configItemId }}">
							<input type="hidden" name="config" value="{{ $config->id }}">
							<input type="hidden" name="item" value="{{ $currentItem->id }}">
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

	<h3>Available items: </h3>
	<table class="ui black table">
		<thead>
			<tr>
				<th><center>ID</center></th>
				<th>Item</th>
				<th><center>Type</center></th>
				<th><center>Preview</center></th>
				<th><center>Add</center></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($availableItems as $availableItem)
			<tr>
				<td><center>{{ $availableItem->id }}</center></td>
				<td><b>{{ $availableItem->title }}</b>{!! empty($availableItem->description) ? "" : "<br />" . $availableItem->description !!}</td>
				<td><center>{{ $availableItem->type == 0 ? "Image" : "Youtube" }}</center></td>
				<td><center><img src={{ "/images/items/" . $availableItem->preview }} class="ui small image"></center></td>
				<td>
					<center>
						<form class="ui form" method="POST" action="/admin/generic/configs/addItem">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="config" value="{{ $config->id }}">
							<input type="hidden" name="item" value="{{ $availableItem->id }}">
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
