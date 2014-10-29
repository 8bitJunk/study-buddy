<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Module extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    protected $table = 'modules';
    protected $guarded = ['id'];

    public function notes (){
        return $this->hasMany('Note');
    }   

    public function users() {
        return $this->belongsToMany('User', 'module_user');
    }

    public function notesForUser($user = null) {
        $user = $user
            ? $user
            : Auth::user();

        return $this->notes()->whereUserId($user->id)->orderBy('created_at','DESC')->get();
    }

    public function announcements() {
        return $this->hasMany('Announcement');
    }

    public function materials() {
        return $this->hasMany('Material');
    }

}
