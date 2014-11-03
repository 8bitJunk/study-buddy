<?php

use Illuminate\Support\Collection;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';
	public $timestamps = false;
	protected $guarded = ['id'];

	protected $hidden = array('password', 'remember_token');

    public function notes() {
        return $this->hasMany('Note');
    }

    public function modules() {
        return $this->belongsToMany('Module', 'module_user');
    }

    public function announcements() {
        $this->load('modules.announcements');
        $announcements = new Collection;

        foreach ($this->modules as $module) {
            $announcements = $announcements->merge($module->announcements);    
        }
        
        return $announcements;
    }


}
