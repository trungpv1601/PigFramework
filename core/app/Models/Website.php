<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $table = 'websites';

    protected $fillable = ['name', 'link', 'xpath'];

    public function cookies()
    {
        return $this->hasMany('App\Models\Cookie', 'websites_id', 'id');
    }
}