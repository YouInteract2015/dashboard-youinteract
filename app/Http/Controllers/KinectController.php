<?php namespace YouInteract\Http\Controllers;

use Request;
use Input;
use Log;
use Validator;
use Session;
use Redirect;
use View;
use DB;
use Route;
use YouInteract\Models\KinectTemplate;
use YouInteract\Models\KinectItem;
use YouInteract\Models\KinectConfig;
use YouInteract\Models\KinectScheduler;
use YouInteract\Models\KinectConfigItem;

class KinectController extends Controller {

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
		$this->middleware('auth'); // To make sure user is logged
		//$this->middleware('guest');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('kinect.home');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function devices()
	{
		$devices = DB::table('kinect_devices')
							->leftjoin('kinect_configs', 'kinect_devices.config_id', '=', 'kinect_configs.id')
							->leftjoin('kinect_templates', 'kinect_configs.template_id', '=', 'kinect_templates.id')
							->select('kinect_devices.*', 'kinect_configs.title as configTitle', 'kinect_templates.id as templateId', 'kinect_templates.title as templateTitle', 'kinect_templates.description as templateDescription', 'kinect_templates.preview as templatePreview')
							->get();
		return view('kinect.devices')->with('devices', $devices);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function configs()
	{
		$templates = KinectTemplate::all();
		$schedulers = KinectScheduler::all();
		$configs = DB::table('kinect_configs')
							->leftjoin('kinect_templates', 'kinect_configs.template_id', '=', 'kinect_templates.id')
							->leftjoin('kinect_schedulers', 'kinect_configs.scheduler_id', '=', 'kinect_schedulers.id')
							->select('kinect_configs.*', 'kinect_templates.id as templateId', 'kinect_templates.title as templateTitle', 'kinect_templates.description as templateDescription', 'kinect_templates.preview as templatePreview', 'kinect_schedulers.description as schedulerId', 'kinect_schedulers.title as schedulerTitle', 'kinect_schedulers.description as schedulerDescription')
							->get();
		$array = array('templates' => $templates, 'schedulers' => $schedulers, 'configs' => $configs);
		return view('kinect.configs')->with($array);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function themes()
	{
		$templates = KinectTemplate::all();
		return view('kinect.themes')->with('templates', $templates);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function apps()
	{
		$apps = KinectItem::all();
		return view('kinect.apps')->with('apps', $apps);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function schedulers()
	{
		return view('kinect.schedulers');
	}

	public function configApps()
	{
		$config = KinectConfig::find(Route::input('id'));
		if(empty($config)) return Redirect::to('/admin/kinect/configs');
		$currentApps = DB::table('kinect_items')
										->join('kinect_config_items', function($join) { $join->on('kinect_items.id', '=', 'kinect_config_items.item_id')->where('kinect_config_items.config_id', '=', Route::input('id')); })
										->select('kinect_items.*', 'kinect_config_items.id as configItemId', 'kinect_config_items.priority')
										->orderBy('kinect_items.id', 'asc')
										->get();
		$availableApps = KinectItem::whereNotExists(function($query) { $query->select(DB::raw(1))->from('kinect_config_items')->whereRaw('kinect_items.id = kinect_config_items.item_id and kinect_config_items.config_id = '.Route::input('id')); } )->get();
		$array = array('currentApps' => $currentApps, 'availableApps' => $availableApps, 'config' => $config);
		return view('kinect.configApps')->with($array);
	}

	public function addApp()
	{
		$v = Validator::make(Request::all(), [
				'appTitle'  => 'required|max:255|min:3',
				'appVersion'  => 'required',
				'attachmentFile' => 'required',
		]);
		if ($v->fails())
		{
			return redirect()->back()->withErrors($v->errors());
		}
		$uniqid = uniqid();
		if(Request::hasFile('attachmentFile'))
		{
			$appFile = Request::file('attachmentFile');
			
			if($appFile->getClientOriginalExtension() == "dll")
			{
				$appFile->move(public_path()."/kinect/apps/", $uniqid.".".$appFile->getClientOriginalExtension());
				$app = new KinectItem();
				$app->title = Request::input('appTitle');
				if(Request::has('appDescription') && !empty(Request::input('appDescription')))
					$app->description = Request::input('appDescription');
				$app->dll = $uniqid.".".$appFile->getClientOriginalExtension();
				if(Request::hasFile('attachmentScreenshot'))
				{
					$ssFile = Request::file('attachmentScreenshot');
					if($ssFile->getClientOriginalExtension() == "png" || $ssFile->getClientOriginalExtension() == "jpg" || $ssFile->getClientOriginalExtension() == "gif")
					{
						$ssFile->move(public_path()."/images/apps/", "ss_".$uniqid.".".$ssFile->getClientOriginalExtension());
						$app->preview = "ss_".$uniqid.".".$ssFile->getClientOriginalExtension();
					}
				}
				$app->version = Request::input('appVersion');
				$app->save();
				Session::flash('success', 'Operation Successful!');
				return Redirect::back()->with('message','Operation Successful!');
			}
			else
				$error = "Bad extension file, item should be a jpg/png/gif file.";
		}
		else
			$error = "There is no item file.";
		Log::error('[addAPP] '.$error);
		Session::flash('error', $error);
		return Redirect::back()->with('message', $error);
	}

	public function removeConfigApp()
	{
		$v = Validator::make(Request::all(), [
				'id' => 'required',
				'config'  => 'required',
				'item' => 'required',
		]);
		if ($v->fails())
		{
			return redirect()->back()->withErrors($v->errors());
		}
		$current = KinectConfigItem::find(Request::input('id'));
		KinectConfigItem::where('config_id', '=', Request::input('config'))
											->where('priority', '>', $current->priority)
											->update(array('priority' => DB::raw('`priority` - 1')));
		KinectConfigItem::destroy(Request::input('id'));
		return Redirect::back()->with('message','Operation Successful!');
	}
	
	public function addConfigApp()
	{
		$v = Validator::make(Request::all(), [
				'config'  => 'required',
				'item' => 'required',
		]);
		if ($v->fails())
		{
			return redirect()->back()->withErrors($v->errors());
		}
		if(KinectConfigItem::whereRaw('config_id = '.Request::input('config').' and item_id = '.Request::input('item'))->count() > 0)
		{
			Session::flash('error', 'There is already that item in config '.Request::input('config'));
			return Redirect::back()->with('message', 'There is already that item in config '.Request::input('config'));
		}
		$configItem = new KinectConfigItem();
		$configItem->config_id = Request::input('config');
		$configItem->item_id = Request::input('item');
		$configItem->status = 1;
		$configItem->priority = KinectConfigItem::whereRaw('config_id = '.Request::input('config').' and status = 1')->count() + 1;
		$configItem->save();
		Session::flash('success', 'Operation Successful!');
		return Redirect::back()->with('message','Operation Successful!');
	}
	
	public function addConfig()
	{
		$v = Validator::make(Request::all(), [
				'configTitle'  => 'required|max:255|min:3',
				'template' => 'required',
				'scheduler' => 'required',
		]);
		if ($v->fails())
		{
			return redirect()->back()->withErrors($v->errors());
		}
		$config = new KinectConfig();
		$config->title = Request::input('configTitle');
		if(Request::has('configDescription') && !empty(Request::input('configDescription')))
			$config->description = Request::input('configDescription');
		$config->template_id = Request::input('template');
		$config->scheduler_id = Request::input('scheduler');
		$config->status = 1;
		$config->default = 0;
		$config->save();
		Session::flash('success', 'Operation Successful!');
		return Redirect::back()->with('message','Operation Successful!');
	}
	
	public function addTheme()
	{
		$v = Validator::make(Request::all(), [
				'templateTitle'  => 'required|max:255|min:3',
				'attachmentFile' => 'required',
		]);
		if ($v->fails())
		{
			return redirect()->back()->withErrors($v->errors());
		}
		$uniqid = uniqid();
		if(Request::has('templateTitle') && !empty(Request::input('templateTitle')))
		{
			if(Request::hasFile('attachmentFile'))
			{
				$templateFile = Request::file('attachmentFile');
				
				if($templateFile->getClientOriginalExtension() == "png" || $templateFile->getClientOriginalExtension() == "jpg" || $templateFile->getClientOriginalExtension() == "gif")
				{
					$templateFile->move(public_path()."/images/themes/", $uniqid.".".$templateFile->getClientOriginalExtension());
					$template = new KinectTemplate();
					$template->title = Request::input('templateTitle');
					if(Request::has('templateDescription') && !empty(Request::input('templateDescription')))
						$template->description = Request::input('templateDescription');
					$template->path = $uniqid.".".$templateFile->getClientOriginalExtension();
					if(Request::hasFile('attachmentScreenshot'))
					{
						$ssFile = Request::file('attachmentScreenshot');
						if($ssFile->getClientOriginalExtension() == "png" || $ssFile->getClientOriginalExtension() == "jpg" || $ssFile->getClientOriginalExtension() == "gif")
						{
							$ssFile->move(public_path()."/images/themes/", $uniqid.".".$ssFile->getClientOriginalExtension());
							$template->preview = $uniqid.".".$ssFile->getClientOriginalExtension();
						}
						else
						{
							$template->preview = $uniqid.".".$templateFile->getClientOriginalExtension();
						}
					}
					$template->save();
					Session::flash('success', 'Operation Successful!');
					return Redirect::back()->with('message','Operation Successful!');
				}
				else
					$error = "Bad extension file, template file should be a png/jpeg/gif file.";
			}
			else
				$error = "There is no theme file.";
		}
		else
			$error = "Title input is empty, please insert a title.";
		Log::error('[addTemplate] '.$error);
		Session::flash('error', $error);
		return Redirect::back()->with('message', $error);
	}
}
