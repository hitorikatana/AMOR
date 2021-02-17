<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();
use Validator;

class Users extends Controller
{
    public function view() {
        DB::enableQueryLog();
        $user = DB::table('tbl_user')
                ->select('tbl_user.user_id as user_id', 'username', 'full_name', 'department_name', 'last_login')
                ->join('tbl_department', 'tbl_user.department_id', '=', 'tbl_department.department_id')
                ->paginate(20);
        return view('users/users', ['user' => $user]);
    }

    public function search(Request $r) {
        DB::enableQueryLog();
        $user = DB::table('tbl_user')
                ->where('username','LIKE',"%".$r->txt_search."%")
                ->join('tbl_department', 'tbl_user.department_id', '=', 'tbl_department.department_id')
                ->paginate(20);
        $user   ->appends(['txt_search' =>$r->txt_search]);
        //dd(DB::getQueryLog());
        return view('users/users', ['user' => $user]);
    }

    public function detail($id) {
        DB::enableQueryLog();
        $id             = Crypt::decrypt($id);
        $user           = DB::table('tbl_user as a')
                        ->select('a.user_id as user_id', 'username', 'full_name', 'a.department_id', 'a.region_id', 'a.parent_user_id', 'a.group_id', 'a.active_status', 'department_name', 'last_login')
                        ->join('tbl_department', 'a.department_id', '=', 'tbl_department.department_id')
                        ->where('a.user_id','=', $id)
                        ->get();

        $department_id  = DB::table('tbl_department')
                        ->get();

        $group_id       = DB::table('tbl_group')
                        ->get();

        $user_id        = DB::select('select * FROM tbl_user WHERE group_id IN (1,2)');
                        //->where('group_id', 'NOT IN', '0')
                        //->get();

        $region_id      = DB::table('tbl_region')
                        ->get();

        $nav_menu_id    = DB::table('tbl_nav_menu as y')
                        ->select("*",
                        DB::raw("(SELECT count(*) FROM tbl_nav_user x WHERE x.nav_menu_id = y.nav_menu_id AND user_id = $id) as ada"))
                        ->join('tbl_nav_header as b', 'b.nav_header_id', '=', 'y.nav_header_id')
                        ->orderby('nav_header_name')
                        ->get();

        return view('users/usersDetail', ['user' => $user, 'department_id' => $department_id, 'group_id' => $group_id, 'user_id' => $user_id, 'region_id' => $region_id, 'nav_menu_id' => $nav_menu_id]);
    }

    public function new() {
        $department_id  = DB::table('tbl_department')
                        ->get();
        
        $group_id       = DB::table('tbl_group')
                        ->get();

        $parent_user_id = DB::select('select * FROM tbl_user where group_id IN (1,2)');
                        //= DB::table('tbl_user')
                        //->where('group_id', 'IN', '(1,2)')
                        //->get();

        $region_id      = DB::table('tbl_region')
                        ->get();
        
        $nav_menu_id    = DB::table('tbl_nav_menu as y')
                        ->select("*",
                            DB::raw("(SELECT count(*) FROM tbl_nav_user x WHERE x.nav_menu_id = y.nav_menu_id)"))
                            ->join('tbl_nav_header as b', 'b.nav_header_id', '=', 'y.nav_header_id')
                        ->get();

        return view('users/usersNew', ['department_id' => $department_id, 'group_id' => $group_id, 'parent_user_id' => $parent_user_id, 'region_id' => $region_id, 'nav_menu_id' => $nav_menu_id]);
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
            'txt_password.required'     => 'Minimum password length 6 digits, consist of number and alphabet',
            'txt_password.min'          => 'Minimum password length 6 digits, consist of number and alphabet',
            'txt_password.alpha_num'    => 'Minimum password length 6 digits, consist of number and alphabet'
        ];

        $this->validate($r, [
            'username'        => 'required|min:5|alpha_num',
            'full_name'       => 'required|min:5|alpha_num ',
            'department_id'   => 'required',
            'group_id'        => 'required',
            'parent_user_id'  => 'required',
            'region_id'       => 'required',
            'txt_password'    => 'required|min:6|alpha_num'
        ], $error_message); 

        $nav_menu_id = $r -> nav_menu_id;
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

        foreach($nav_menu_id as $key=>$value) {
            $arrData = array(
                'nav_menu_id' => $nav_menu_id[$key]
            );
            DB::table('tbl_nav_user')->insert([
                'nav_menu_id' => $nav_menu_id[$key],
                'user_id'     => 1,
                'client_id'   => 'AMOR'
            ]);
        }
        return redirect('/users/users');
    }

    public function edit(Request $r) {
        $nav_menu_id = $r -> nav_menu_id;
        DB::table('tbl_user')
        ->where('user_id', $r->user_id)
        ->update([
            'full_name' => $r->full_name
        ]);

        DB::table('tbl_nav_user')
        ->where('user_id', $r->user_id)
        ->delete();
        
        foreach($nav_menu_id as $key=>$value) {
            $arrData = array(
                'nav_menu_id' => $nav_menu_id[$key]
            );
            DB::table('tbl_nav_user')->insert([
                'nav_menu_id' => $nav_menu_id[$key],
                'user_id'     => $r->user_id,
                'client_id'   => 'AMOR'
            ]);
        }

        return redirect('/users/users');
    }



    public function password() {
        return view('profile/password');
    }
}
