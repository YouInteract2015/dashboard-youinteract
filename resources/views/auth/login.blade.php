@extends('main')

@section('content')
<div class="fourteen wide column">
	<div class="ui form attached fluid segment">
		<h3 class="ui inverted white block header">SIGN IN</h3>
		<div class="ui one column grid basic segment">
			<div class="column">
				<div class="ui three column grid basic segment">
					<div class="column">
						<!-- nao usada -->
					</div>
					<div class="column">
						<form class="ui form" role="form" method="POST" action="/auth/login">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="field">
								<label>E-mail Address</label>
								<div class="ui left labeled icon input">
									<input type="text" name="email" />
									<i class="mail icon"></i>
								</div>
							</div>
							<div class="field">
								<label>Password</label>
								<div class="ui left labeled icon input">
									<input type="password" name="password" />
									<i class="lock icon"></i>
								</div>
							</div>
							<div class="inline field">
								<div class="ui checkbox">
									<input id="remember" type="checkbox" />
									<label for="remember">Remember me</label>
								</div>
							</div>
							<button type="submit" class="ui red button">Sign In</button>
						</form>
					</div>
					<div class="column">
						<!-- nao usada -->
					</div>
				</div>
			</div>
		</div>
		<div class="ui divider"></div>
		<div class="ui message">
			<i class="icon help"></i>
			<a href="/password/email">Forgot your password?</a>
		</div>
	</div>
	@if (count($errors) > 0)
	<div class="ui bottom attached error message">
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
</div>
@endsection
