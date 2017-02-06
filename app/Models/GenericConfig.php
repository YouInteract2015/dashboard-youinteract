<?php namespace YouInteract\Models;

use Illuminate\Database\Eloquent\Model;

class GenericConfig extends Model {
	
	public function template()
	{
		return $this->hasOne('YouInteract\Models\GenericTemplate');
	}
	
	public function scheduler()
	{
		return $this->hasOne('YouInteract\Models\GenericScheduler');
	}
	
}
