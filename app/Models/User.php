<?php
namespace App\Models;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{


    protected $table = 'tbl_user';
    protected $fillable = array('username', 'password');    
    public $timestamps = true;
    public static $rules = array();    
}
