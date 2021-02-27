<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CommonModel extends Model
{
    protected $table        = 'tbl_department';
    protected $primaryKey   = 'department_id';

    public function tbl_department() {
        $department_id  = DB::table('tbl_department') //get department data, will compare to user data
        ->get();
    }

    public function children() {
        return $this->hasMany('App\Models\NavigationModel', 'parent_id');
    }

}
