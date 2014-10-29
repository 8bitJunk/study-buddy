<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Material extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    protected $table = 'module_materials';
    protected $guarded = ['id'];
    public $timestamps = true;


    public function modules () {
        return $this->belongsTo('Module');
    }

    public function getUrlAttribute() {
        return $this->material_path . $this->material_name;
    }
}
