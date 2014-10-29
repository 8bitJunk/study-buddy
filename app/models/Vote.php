<?php

use Illuminate\Support\Collection;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Vote extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    protected $table = 'vote';
    protected $guarded = ['id'];

    public function Note() {
        return $this->belongsTo('Note');
    }
}
