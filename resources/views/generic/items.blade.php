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
			<i class="list layout icon"></i> List of available Items
	</h3>
	<table class="ui black table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th><center>Type</center></th>
				<th><center>Preview</center></th>
				<th><center>Actions</center></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($items as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td><b>{{ $item->title }}</b>{!! empty($item->description) ? "" : "<br />" . $item->description !!}</td>
				<td><center>{{ $item->type == 0 ? "Image" : "Youtube" }}</center></td>
				<td><center><img src={{ "/images/items/" . $item->preview }} class="ui small image"></center></td>
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

	<br />

	<h3 class="ui inverted white block header">Add Item</h3>
	<form class="ui form" method="POST" action="/admin/generic/items/add" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="field">
			<label>Title:</label> <input name="itemTitle" id="itemTitle" type="text">
		</div>
		<div class="field">
			<label>Description:</label> <input name="itemDescription" id="itemDescription" type="text">
		</div>
		<div class="field">
			<label>Type</label>
			<div class="ui selection dropdown">
				<input name="type" type="hidden">
				<div class="default text">Type</div>
				<i class="dropdown icon"></i>
				<div class="menu">
					<div class="item" data-value="0">Image</div>
					<div class="item" data-value="1">Youtube</div>
				</div>
			</div>
		</div>
		<div class="field">
			<label>Youtube url:</label> <input name="itemUrl" id="itemUrl" type="text">
		</div>
		<b>File (jpg, png, gif):</b>
		<div class="field">
			<input type="file" id="attachmentFile" name="attachmentFile">
		</div>
		<b>Screenshot (jpg, png, gif):</b>
		<div class="field">
			<input type="file" id="attachmentScreenshot" name="attachmentScreenshot">
		</div>
		<button type="submit" class="ui red button">Add</button>
	</form>

</div>
@endsection
