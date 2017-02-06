<?php namespace YouInteract\Http\Controllers;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth'); // To make sure user is logged
		//$this->middleware('guest');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function about()
	{
		return view('about');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function help()
	{
		return view('help');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function downloads()
	{
		return view('downloads');
	}

}
