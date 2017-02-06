<?php namespace YouInteract\Models;

use Illuminate\Database\Eloquent\Model;

class KinectConfig extends Model {
	
	public function template()
	{
		return $this->hasOne('YouInteract\Models\KinectTemplate');
	}
	
	public function scheduler()
	{
		return $this->hasOne('YouInteract\Models\KinectScheduler');
	}
	
}
