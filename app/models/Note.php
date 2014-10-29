<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Note extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    protected $table = 'notes';
    protected $guarded = ['id'];
    // protected $hidden = ['id']; // prevents being returned by ajax
    // protected $appends = ['greeting']; // appends to json response


    // dynamic properties. Look like properties but derived from methods
    // how it may be called: $note->greeting
    // public function getGreetingAttribute() { // getXAttribute
    //     return 'Hello there';
    // }

    public function module() {
        return $this->belongsTo('Module');
    }

    public function vote() {
        return $this->hasMany('Vote');
    }
}
