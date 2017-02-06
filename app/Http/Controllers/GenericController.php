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
use YouInteract\Models\GenericTemplate;
use YouInteract\Models\GenericItem;
use YouInteract\Models\GenericConfig;
use YouInteract\Models\GenericScheduler;
use YouInteract\Models\GenericConfigItem;

class GenericController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Generic Controller
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
		return view('generic.home');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function devices()
	{
		$devices = DB::table('generic_devices')
							->leftjoin('generic_configs', 'generic_devices.config_id', '=', 'generic_configs.id')
							->leftjoin('generic_templates', 'generic_configs.template_id', '=', 'generic_templates.id')
							->select('generic_devices.*', 'generic_configs.title as configTitle', 'generic_templates.id as templateId', 'generic_templates.title as templateTitle', 'generic_templates.description as templateDescription', 'generic_templates.preview as templatePreview')
							->get();
		return view('generic.devices')->with('devices', $devices);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function configs()
	{
		$templates = GenericTemplate::all();
		$schedulers = GenericScheduler::all();
		$configs = DB::table('generic_configs')
							->leftjoin('generic_templates', 'generic_configs.template_id', '=', 'generic_templates.id')
							->leftjoin('generic_schedulers', 'generic_configs.scheduler_id', '=', 'generic_schedulers.id')
							->select('generic_configs.*', 'generic_templates.id as templateId', 'generic_templates.title as templateTitle', 'generic_templates.description as templateDescription', 'generic_templates.preview as templatePreview', 'generic_schedulers.description as schedulerId', 'generic_schedulers.title as schedulerTitle', 'generic_schedulers.description as schedulerDescription')
							->get();
		$array = array('templates' => $templates, 'schedulers' => $schedulers, 'configs' => $configs);
		return view('generic.configs')->with($array);
	}

	public function configItems()
	{
		$config = GenericConfig::find(Route::input('id'));
		if(empty($config)) return Redirect::to('/admin/generic/configs');
		$currentItems = DB::table('generic_items')
										->join('generic_config_items', function($join) { $join->on('generic_items.id', '=', 'generic_config_items.item_id')->where('generic_config_items.config_id', '=', Route::input('id')); })
										->select('generic_items.*', 'generic_config_items.id as configItemId', 'generic_config_items.priority')
										->orderBy('generic_config_items.priority', 'asc')
										->get();
		$availableItems = GenericItem::whereNotExists(function($query) { $query->select(DB::raw(1))->from('generic_config_items')->whereRaw('generic_items.id = generic_config_items.item_id and generic_config_items.config_id = '.Route::input('id')); } )->get();
		$array = array('currentItems' => $currentItems, 'availableItems' => $availableItems, 'config' => $config);
		return view('generic.configItems')->with($array);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function templates()
	{
		$templates = GenericTemplate::all();
		return view('generic.templates')->with('templates', $templates);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function items()
	{
		$items = GenericItem::all();
		return view('generic.items')->with('items', $items);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function schedulers()
	{
		return view('generic.schedulers');
	}
	
	public function increaseConfigItemPriority()
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
		$current = GenericConfigItem::find(Request::input('id'));
		GenericConfigItem::where('config_id', '=', Request::input('config'))
											->where('priority', '=', $current->priority - 1)
											->update(array('priority' => DB::raw('`priority` + 1')));
		$current->priority -= 1;
		$current->save();
		return Redirect::back()->with('message','Operation Successful!');
	}
	
	public function decreaseConfigItemPriority()
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
		$current = GenericConfigItem::find(Request::input('id'));
		GenericConfigItem::where('config_id', '=', Request::input('config'))
											->where('priority', '=', $current->priority + 1)
											->update(array('priority' => DB::raw('`priority` - 1')));
		$current->priority += 1;
		$current->save();
		return Redirect::back()->with('message','Operation Successful!');
	}
	
	public function removeConfigItem()
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
		$current = GenericConfigItem::find(Request::input('id'));
		GenericConfigItem::where('config_id', '=', Request::input('config'))
											->where('priority', '>', $current->priority)
											->update(array('priority' => DB::raw('`priority` - 1')));
		GenericConfigItem::destroy(Request::input('id'));
		return Redirect::back()->with('message','Operation Successful!');
	}
	
	public function addConfigItem()
	{
		$v = Validator::make(Request::all(), [
				'config'  => 'required',
				'item' => 'required',
		]);
		if ($v->fails())
		{
			return redirect()->back()->withErrors($v->errors());
		}
		if(GenericConfigItem::whereRaw('config_id = '.Request::input('config').' and item_id = '.Request::input('item'))->count() > 0)
		{
			Session::flash('error', 'There is already that item in config '.Request::input('config'));
			return Redirect::back()->with('message', 'There is already that item in config '.Request::input('config'));
		}
		$configItem = new GenericConfigItem();
		$configItem->config_id = Request::input('config');
		$configItem->item_id = Request::input('item');
		$configItem->status = 1;
		$configItem->priority = GenericConfigItem::whereRaw('config_id = '.Request::input('config').' and status = 1')->count() + 1;
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
		$config = new GenericConfig();
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
	
	public function addItem()
	{
		$v = Validator::make(Request::all(), [
				'itemTitle'  => 'required|max:255|min:3',
				'attachmentFile' => 'required_if:type,0',
				'itemUrl' => 'required_if:type,1',
		]);
		if ($v->fails())
		{
			return redirect()->back()->withErrors($v->errors());
		}
		$uniqid = uniqid();
		if(Request::input('type') == 0)
		{
			if(Request::hasFile('attachmentFile'))
			{
				$itemFile = Request::file('attachmentFile');
				
				if($itemFile->getClientOriginalExtension() == "png" || $itemFile->getClientOriginalExtension() == "jpg" || $itemFile->getClientOriginalExtension() == "gif")
				{
					$itemFile->move(public_path()."/images/items/", $uniqid.".".$itemFile->getClientOriginalExtension());
					$item = new GenericItem();
					$item->title = Request::input('itemTitle');
					if(Request::has('itemDescription') && !empty(Request::input('itemDescription')))
						$item->description = Request::input('itemDescription');
					$item->file = $uniqid.".".$itemFile->getClientOriginalExtension();
					if(Request::hasFile('attachmentScreenshot'))
					{
						$ssFile = Request::file('attachmentScreenshot');
						if($ssFile->getClientOriginalExtension() == "png" || $ssFile->getClientOriginalExtension() == "jpg" || $ssFile->getClientOriginalExtension() == "gif")
						{
							$ssFile->move(public_path()."/images/items/", "ss_".$uniqid.".".$ssFile->getClientOriginalExtension());
							$item->preview = "ss_".$uniqid.".".$ssFile->getClientOriginalExtension();
						}
					}
					$item->save();
					Session::flash('success', 'Operation Successful!');
					return Redirect::back()->with('message','Operation Successful!');
				}
				else
					$error = "Bad extension file, item should be a jpg/png/gif file.";
			}
			else
				$error = "There is no item file.";
		}
		else
		{
			$item = new GenericItem();
			$item->title = Request::input('itemTitle');
			if(Request::has('itemDescription') && !empty(Request::input('itemDescription')))
				$item->description = Request::input('itemDescription');
			$item->code = Request::input('itemUrl');
			$item->save();
			Session::flash('success', 'Operation Successful!');
			return Redirect::back()->with('message','Operation Successful!');
		}
		Log::error('[addTemplate] '.$error);
		Session::flash('error', $error);
		return Redirect::back()->with('message', $error);
	}
	
	public function addTemplate()
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
				
				if($templateFile->getClientOriginalExtension() == "html")
				{
					$templateFile->move(base_path()."/resources/views/generic/templates/", $uniqid.".blade.php");
					if(Request::hasFile('attachmentCSS'))
					{
						$cssFile = Request::file('attachmentCSS');
						if($cssFile->getClientOriginalExtension() == "css")
							$cssFile->move(public_path()."/css/templates/", $uniqid.".css");
					}
					if(Request::hasFile('attachmentJS'))
					{
						$jsFile = Request::file('attachmentJS');
						if($jsFile->getClientOriginalExtension() == "js")
							$jsFile->move(public_path()."/js/templates/", $uniqid.".js");
					}
					$template = new GenericTemplate();
					$template->title = Request::input('templateTitle');
					if(Request::has('templateDescription') && !empty(Request::input('templateDescription')))
						$template->description = Request::input('templateDescription');
					$template->view = $uniqid;
					if(Request::hasFile('attachmentScreenshot'))
					{
						$ssFile = Request::file('attachmentScreenshot');
						if($ssFile->getClientOriginalExtension() == "png" || $ssFile->getClientOriginalExtension() == "jpg" || $ssFile->getClientOriginalExtension() == "gif")
						{
							$ssFile->move(public_path()."/images/templates/", $uniqid.".".$ssFile->getClientOriginalExtension());
							$template->preview = $uniqid.".".$ssFile->getClientOriginalExtension();
						}
					}
					$template->status = 1;
					$template->save();
					Session::flash('success', 'Operation Successful!');
					return Redirect::back()->with('message','Operation Successful!');
				}
				else
					$error = "Bad extension file, template file should be a html file.";
			}
			else
				$error = "There is no template file.";
		}
		else
			$error = "Title input is empty, please insert a title.";
		Log::error('[addTemplate] '.$error);
		Session::flash('error', $error);
		return Redirect::back()->with('message', $error);
	}

}
