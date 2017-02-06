@extends('main')

@section('content')
<div class="fourteen wide column">
	<div class="ui three column center aligned stackable divided grid">
		<div class="column">
			<div class="ui icon header">
				<i class="file code outline icon"></i>
				Documentation
			</div>  
			<p>Take a look about all the information about YouInteract</p>
			<p>
				<a class="ui button" href="apidocs/index.html">
					Consult
					<i class="right chevron icon"></i>
				</a>
			</p>
		</div>
		<div class="column">
			<div class="ui icon header">
				<i class="download icon"></i>
				Downloads
			</div>
			<p>Download our YouInteract API.</p>
			<p>
				<a class="ui button" href="/downloads">
					Download
					<i class="right chevron icon"></i>
				</a>
			</p>
		</div>
		<div class="column">
			<div class="ui icon header">
				<i class="users icon"></i>
					Project Description
			</div>
			<p>See the project description and our team</p>
			<p>
					<a class="ui button" href="about.html">
							View
							<i class="right chevron icon"></i>
					</a>
			</p>
		</div>

	</div>
</div>
@endsection
