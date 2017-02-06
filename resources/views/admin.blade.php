@extends('main')

@section('content')
<!-- Kinect -->
<div class="fourteen wide column">
	<h3 class="ui inverted white block header"> YOUINTERACT CONFIGURATION > KINECT </h3>
	<div class="ui vertical feature segment">
		<div class="ui six column center aligned stackable grid">
			<div class="column">
				<div class="ui icon header">
					<div class="ui inverted purple button">
						<a style="color:#000" href="/admin/kinect/devices"><i class="laptop icon"></i> Devices</a>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui icon header">
					<div class="ui inverted purple button">
						<a style="color:#000" href="/admin/kinect/configs"><i class="settings icon"></i> Configs</a>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui icon header">
					<div class="ui inverted purple button">
						<a style="color:#000" href="/admin/kinect/themes"><i class="theme icon"></i> Themes</a>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui icon header">
					<div class="ui inverted purple button">
						<a style="color:#000" href="/admin/kinect/apps"><i class="cubes icon"></i> Apps</a>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui icon header">
					<div class="ui inverted purple button">
						<a style="color:#000" href="/admin/kinect/schedulers"><i class="time icon"></i> Schedulers</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<br />

<!-- Generic --> 
<div class="fourteen wide column">
	<h3 class="ui inverted white block header"> YOUINTERACT CONFIGURATION > GENERIC </h3>
	<div class="ui vertical feature segment">
		<div class="ui six column center aligned stackable grid">
			<div class="column">
				<div class="ui icon header">
					<div class="ui inverted purple button">
						<a style="color:#000" href="/admin/generic/devices"><i class="desktop icon"></i> Devices</a>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui icon header">
					<div class="ui inverted purple button">
						<a style="color:#000" href="/admin/generic/configs"><i class="settings icon"></i> Configs</a>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui icon header">
					<div class="ui inverted purple button">
						<a style="color:#000" href="/admin/generic/templates"><i class="theme icon"></i> Templates</a>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui icon header">
					<div class="ui inverted purple button">
						<a style="color:#000" href="/admin/generic/items"><i class="cubes icon"></i> Items</a>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="ui icon header">
					<div class="ui inverted purple button">
						<a style="color:#000" href="/admin/generic/schedulers"><i class="time icon"></i> Schedulers</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
