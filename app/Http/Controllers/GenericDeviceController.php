<?php namespace YouInteract\Http\Controllers;

use Request;
use DB;
use YouInteract\Models\GenericDevice;
use YouInteract\Models\GenericTemplate;
use YouInteract\Models\GenericItem;
use YouInteract\Models\GenericConfig;
use YouInteract\Models\GenericScheduler;
use YouInteract\Models\GenericConfigItem;

class GenericDeviceController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Generic Device Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$device = GenericDevice::where('ip', '=', Request::getClientIp())->first();
		// If device doesnt exist, add new with a default config
		if(empty($device))
		{
			$device = new GenericDevice();
			$device->title = "Added by YouInteract Portal";
			$device->ip = Request::getClientIp();
			$device->config_id = GenericConfig::where('default', '=', '1')->first()->id;
			$device->status = 1;
			$device->save();
		}
		$config = GenericConfig::find($device->config_id);
		$template = GenericTemplate::find($config->template_id);
		$items = DB::table('generic_items')
										->join('generic_config_items', function($join) { $join->on('generic_items.id', '=', 'generic_config_items.item_id'); })
										->where('generic_config_items.config_id', '=', $device->config_id)
										->select('generic_items.*', 'generic_config_items.id as configItemId', 'generic_config_items.priority')
										->orderBy('generic_config_items.priority', 'asc')
										->get();
		$i = 1;
		$array = array();
		foreach($items as $item)
			$array["item_".$i++] = "/images/items/".$item->file;
		while($i < 20) $array["item_".$i++] = "/images/items/unavailable.jpg";
		$array['css'] = "/css/templates/".$template->view.".css";
		$array['js'] = "/js/templates/".$template->view.".js";
		return view('generic.templates.'.$template->view)->with($array);
	}
	
	/**
	 * Show template with a specific config id
	 *
	 * @id config
	 * @return Response
	*/
	public function config()
	{
		$config = GenericConfig::find(Route::input('id'));
		if(empty($config)) return Redirect::to('/generic');
		$device = GenericDevice::where('ip', '=', Request::getClientIp())->first();
		// If device doesnt exist, add new
		if(empty($device))
		{
			$device = new GenericDevice();
			$device->title = "Added by YouInteract Portal";
			$device->ip = Request::getClientIp();
			$device->config_id = Route::input('id');
			$device->status = 1;
			$device->save();
		}
		$template = GenericTemplate::find($config->template_id);
		$items = DB::table('generic_items')
										->join('generic_config_items', function($join) { $join->on('generic_items.id', '=', 'generic_config_items.item_id'); })
										->where('generic_config_items.config_id', '=', Route::input('id'))
										->select('generic_items.*', 'generic_config_items.id as configItemId', 'generic_config_items.priority')
										->orderBy('generic_config_items.priority', 'asc')
										->get();
		$i = 1;
		$array = array();
		foreach($items as $item)
			$array["item_".$i++] = "/images/items/".$item->file;
		while($i < 20) $array["item_".$i++] = "/images/items/unavailable.jpg";
		$array['css'] = "/css/templates/".$template->view.".css";
		$array['js'] = "/js/templates/".$template->view.".js";
		return view('generic.templates.'.$template->view)->with($array);
	}

}
