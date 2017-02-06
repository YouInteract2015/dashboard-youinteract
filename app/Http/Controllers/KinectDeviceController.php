<?php namespace YouInteract\Http\Controllers;

use Request;
use DB;
use View;
use Route;
use Redirect;
use Response;
use YouInteract\Models\KinectDevice;
use YouInteract\Models\KinectTemplate;
use YouInteract\Models\KinectItem;
use YouInteract\Models\KinectConfig;
use YouInteract\Models\KinectScheduler;
use YouInteract\Models\KinectConfigItem;

class KinectDeviceController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Kinect Device Controller
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
		$device = KinectDevice::where('ip', '=', Request::getClientIp())->first();
		// If device doesnt exist, add new with a default config
		if(empty($device))
		{
			$device = new KinectDevice();
			$device->title = "Added by YouInteract Portal";
			$device->ip = Request::getClientIp();
			$device->config_id = KinectConfig::where('default', '=', '1')->first()->id;
			$device->status = 1;
			$device->save();
		}
		$config = KinectConfig::find($device->config_id);
		$template = KinectTemplate::find($config->template_id);
		$items = DB::table('kinect_items')
										->join('kinect_config_items', function($join) { $join->on('kinect_items.id', '=', 'kinect_config_items.item_id'); })
										->where('kinect_config_items.config_id', '=', $device->config_id)
										->select('kinect_items.*', 'kinect_config_items.id as configItemId', 'kinect_config_items.priority')
										->orderBy('kinect_config_items.priority', 'asc')
										->get();
		$i = 1;
		$array = array('device' => $device, 'config' => $config, 'items' => $items, 'template' => $template);
		$content = View::make('kinect.xmlConfig')->with($array);
		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}
	
	/**
	 * Show template with a specific config id
	 *
	 * @id config
	 * @return Response
	*/
	public function config()
	{
		$config = KinectConfig::find(Route::input('id'));
		if(empty($config)) return Redirect::to('/kinect');
		$device = KinectDevice::where('ip', '=', Request::getClientIp())->first();
		// If device doesnt exist, add new with a default config
		if(empty($device))
		{
			$device = new KinectDevice();
			$device->title = "Added by YouInteract Portal";
			$device->ip = Request::getClientIp();
			$device->config_id = Route::input('id');
			$device->status = 1;
			$device->save();
		}
		$template = KinectTemplate::find($config->template_id);
		$items = DB::table('kinect_items')
										->join('kinect_config_items', function($join) { $join->on('kinect_items.id', '=', 'kinect_config_items.item_id'); })
										->where('kinect_config_items.config_id', '=', Route::input('id'))
										->select('kinect_items.*', 'kinect_config_items.id as configItemId', 'kinect_config_items.priority')
										->orderBy('kinect_config_items.priority', 'asc')
										->get();
		$i = 1;
		$array = array();
		$array = array('devices' => $device, 'configs' => $config, 'items' => $items, 'templates' => $template);
		$content = View::make('kinect.xmlConfig')->with($array);
		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}

}
