<?php

namespace App\Http\Controllers;

use App\Models\CommonModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\CommonController;
use App\Models\DepartmentModel;
Paginator::useBootstrap();
use Validator;

class UsersController extends Controller
{
    public function view() {
        DB::enableQueryLog();
        $user = DB::table('tbl_user')
                ->select('tbl_user.user_id as user_id', 'username', 'full_name', 'department_name', 'last_login')
                ->join('tbl_department', 'tbl_user.department_id', '=', 'tbl_department.department_id')
                ->paginate(20);
        return view('users/usersList', ['user' => $user]);
    }

    public function search(Request $r) {
        DB::enableQueryLog();
        $user = DB::table('tbl_user')
                ->where('username','LIKE',"%".$r->txt_search."%")
                ->join('tbl_department', 'tbl_user.department_id', '=', 'tbl_department.department_id')
                ->paginate(20);
        $user   ->appends(['txt_search' =>$r->txt_search]);
        //dd(DB::getQueryLog());
        return view('users/usersList', ['user' => $user]);
    }

    public function detail($id) {
        DB::enableQueryLog();
        $id             = Crypt::decrypt($id); //decrypt user_id
        $user           = DB::table('tbl_user as a') //get user data except nav_menu
                            ->select('a.user_id as user_id', 'username', 'full_name', 'a.department_id', 'a.region_id', 'a.parent_user_id', 'a.group_id', 'a.active_status', 'department_name', 'last_login')
                            ->join('tbl_department', 'a.department_id', '=', 'tbl_department.department_id')
                            ->where('a.user_id','=', $id)
                            ->get();

        $department_id  = DepartmentModel::all();

        $group_id       = DB::table('tbl_group') //get group ID data, will compare to user data
                            ->get();

        $user_id        = DB::table('tbl_user') //get superior user data, will compare to user data
                            ->where('user_type','<>','CONTACT')
                            ->whereIn('group_id', [1,2])
                            ->get();

        $region_id      = DB::table('tbl_region') //get region data, will compare to user data
                            ->get();

        $nav_id         = DB::table('tbl_nav as y') //get all nav menu, will compare to user data
                            ->select("*",
                            DB::raw("(SELECT count(*) FROM tbl_nav_user x WHERE x.nav_id = y.nav_id AND user_id = $id) as ada"))
                            ->where('parent_id', '>', 0)
                            ->orderby('nav_name')
                            ->get();

        $nav_user_id    = DB::table('tbl_nav_user') //get all nav menu, will compare to user data
                            ->select('nav_id','user_id')
                            ->where('user_id', '=', $id)
                            ->get();

        return view('users/usersDetail', ['user' => $user, 'department_id' => $department_id, 'group_id' => $group_id, 'user_id' => $user_id, 'region_id' => $region_id, 'nav_id' => $nav_id]);
    }

    public function new() {
        $department_id  = DepartmentModel::all();

        $group_id       = DB::table('tbl_group')
                        ->get();

        $parent_user_id = DB::select('select * FROM tbl_user where group_id IN (1,2)');
                        //= DB::table('tbl_user')
                        //->where('group_id', 'IN', '(1,2)')
                        //->get();

        $region_id      = DB::table('tbl_region')
                        ->get();

        $nav_id         = DB::table('tbl_nav')
                        ->where('parent_id', '>', 0)
                        ->orderBy('nav_name')
                        ->get();

        return view('users/usersNew', ['department_id' => $department_id, 'group_id' => $group_id, 'parent_user_id' => $parent_user_id, 'region_id' => $region_id, 'nav_id' => $nav_id]);
    }

    public function add(Request $r) {

        $error_message = [
            'username.required'         => 'Username is mandatory. 5 characters minimum. Number or alphabet is allowed',
            'username.min'              => 'Username is mandatory. 5 characters minimum. Number or alphabet is allowed',
            'username.alpha_num'        => 'Username is mandatory. 5 characters minimum. Number or alphabet is allowed',
            'full_name.required'        => 'full name is mandatory. 5 characters minimum',
            'full_name.min'             => 'full name is mandatory. 5 characters minimum',
            'full_name.alpha_num'       => 'full name is mandatory. 5 characters minimum',
            'department_id.required'    => 'Please choose department',
            'group_id.required'         => 'Please choose group ID',
            'parent_user_id.required'   => 'Please choose his/her superior',
            'region_id.required'        => 'Please choose region',
            'password.required'         => 'Minimum password length 6 digits, consist of number and alphabet',
            'password.min'              => 'Minimum password length 6 digits, consist of number and alphabet',
            'password.alpha_num'        => 'Minimum password length 6 digits, consist of number and alphabet',
            'password.confirmed'        => 'Both password did not match',
            'nav_id.required'           => 'Please choose module access'
        ];

        $this->validate($r, [
            'username'                  => 'required|min:5|alpha_num',
            'full_name'                 => 'required|min:5|alpha_num ',
            'department_id'             => 'required',
            'group_id'                  => 'required',
            'parent_user_id'            => 'required',
            'region_id'                 => 'required',
            'password'                  => 'required|confirmed|min:6|alpha_num',
            'nav_id'                    => 'required'
        ], $error_message);

        //check if there is a duplicate user
        $duplicate          = DB::table('tbl_user')
                            ->where('username','=', $r->username)
                            ->count();

        if($duplicate>0) {
            return redirect('/users/usersNew')->with('danger','Duplicate username. This username already exist');
        }

        $nav_id = $r -> nav_id;
        DB::table('tbl_user')->insert([
            'username'      => $r -> username,
            'full_name'     => $r -> full_name,
            'active_status' => $r -> active_status,
            'department_id' => $r -> department_id,
            'group_id'      => $r -> group_id,
            'parent_user_id'=> $r -> parent_user_id,
            'region_id'     => $r -> region_id,
            'password'      => Hash::make($r -> txt_password),
            'created_date'  => Carbon::now()
        ]);

        foreach($nav_id as $key=>$value) {
            $arrData = array(
                'nav_id' => $nav_id[$key]
            );
            DB::table('tbl_nav_user')->insert([
                'nav_id' => $nav_id[$key],
                'user_id'     => 1,
                'client_id'   => 'AMOR'
            ]);
        }
        return redirect('/users/list')->with('status','Data added successfully');
    }

    public function edit(Request $r) {

        $error_message = [
            'username.required'         => 'Username is mandatory. 5 characters minimum. Number or alphabet is allowed',
            'username.min'              => 'Username is mandatory. 5 characters minimum. Number or alphabet is allowed',
            'username.alpha_num'        => 'Username is mandatory. 5 characters minimum. Number or alphabet is allowed',
            'full_name.required'        => 'full name is mandatory. 5 characters minimum',
            'full_name.min'             => 'full name is mandatory. 5 characters minimum',
            'full_name.alpha_num'       => 'full name is mandatory. 5 characters minimum',
            'department_id.required'    => 'Please choose department',
            'group_id.required'         => 'Please choose group ID',
            'parent_user_id.required'   => 'Please choose his/her superior',
            'region_id.required'        => 'Please choose region',
            'password.required'         => 'Minimum password length 6 digits, consist of number and alphabet',
            'password.min'              => 'Minimum password length 6 digits, consist of number and alphabet',
            'password.alpha_num'        => 'Minimum password length 6 digits, consist of number and alphabet',
            'password.confirmed'        => 'Both password did not match',
            'nav_id.required'           => 'Please choose module access'
        ];

        $this->validate($r, [
            'username'                  => 'required|min:5|alpha_num',
            'full_name'                 => 'required|min:5|alpha_num ',
            'department_id'             => 'required',
            'group_id'                  => 'required',
            'parent_user_id'            => 'required',
            'region_id'                 => 'required',
            'password'                  => 'required|confirmed|min:6|alpha_num',
            'nav_id'                    => 'required'
        ], $error_message);

        $nav_id = $r -> nav_id;
        DB::table('tbl_user')
        ->where('user_id', $r->user_id)
        ->update([
            'full_name' => $r->full_name
        ]);

        DB::table('tbl_nav_user')
        ->where('user_id', $r->user_id)
        ->delete();

        foreach($nav_id as $key=>$value) {
            $arrData = array(
                'nav_id' => $nav_id[$key]
            );
            DB::table('tbl_nav_user')->insert([
                'nav_id' => $nav_id[$key],
                'user_id'     => $r->user_id,
                'client_id'   => 'AMOR'
            ]);
        }

        return redirect('/users/list')->with('status','Data updated successfully');
    }



    public function password() {
        return view('profile/password');
    }
}
