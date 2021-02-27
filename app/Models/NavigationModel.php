<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationModel extends Model
{
    protected $table        = 'tbl_nav';
    protected $primaryKey   = 'nav_id';

    public function parent() {
        return $this->belongsTo('App\Models\NavigationModel', 'parent_id');
       // return $this->belongsTo('App\tbl_nav', 'parent_id');
    }

    public function children() {
        return $this->hasMany('App\Models\NavigationModel', 'parent_id');
    }

}
