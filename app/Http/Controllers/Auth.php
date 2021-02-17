<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{
    public function login(Request $r) {
        DB::enableQueryLog();
        $data = DB::table('tbl_user')
                ->select('user_id', 'user_photo', 'username', 'password', 'full_name', 'group_id', 'client_id', 'parent_user_id', 'timezone_id')
                ->where('active_status', '=', 1)
                ->where('username', '=', $r->txt_username)
                ->get();
        return view('profile/home', ['data' => $data]);
    }


    public function add(Request $r) {

        $error_message = [
            'required'  => ':attribute is mandatory',
            'min'       => ':attribute: minimum :min characters'
        ];

        $this->validate($r, [
            'username'        => 'required|min:5|alpha_num',
            'full_name'       => 'required|min:5|alpha_num ',
            'department_id'   => 'required',
            'group_id'        => 'required',
            'parent_user_id'  => 'required',
            'region_id'       => 'required',
            'txt_password'    => 'required|alpha_num'
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
