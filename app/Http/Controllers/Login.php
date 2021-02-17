<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\User;
use Illuminate\Support\Facades\Route;

class Login extends Controller
{
    public function index() {
        $title      = 'Get AMOR';
        $username   = 'Username';
        $password   = 'Enter password'; 
        return view('login', ['title' => $title, 'username' => $username, 'password' => $password]);
    }

    public function auth(Request $r) {

        $username = $r->input('txt_username');
        $password = $r->input('txt_password');

        $error_message = [
            'txt_username.required' => 'Please fill username',
            'txt_password.required' => 'Please fill password'
        ];

        $this->validate($r, [
            'txt_username' => 'required',
            'txt_password' => 'required'
        ], $error_message);

        $data = DB::table('tbl_user')
                ->select('user_id', 'user_photo', 'username', 'password', 'full_name', 'group_id', 'client_id', 'parent_user_id', 'timezone_id')
                ->where('active_status', '=', 1)
                ->where('username', '=', $username)
                ->limit(1)
                ->get();
        if(!$data->isEmpty()) {
            if(Hash::check($password, $data[0]->password)) {
                $user_id = $data[0]->user_id;

                //generate menu based on user
                //DB::enableQueryLog();
                $menu1 = DB::table('tbl_nav_user as a')
                        ->select('c.nav_header_id', 'c.nav_header_icon', 'c.nav_header_name')
                        ->join('tbl_nav_menu as b', 'a.nav_menu_id', '=', 'b.nav_menu_id')
                        ->join('tbl_nav_header as c', 'c.nav_header_id', '=', 'b.nav_header_id')
                        ->where('a.user_id', '=', $data[0]->user_id)
                        ->orderby('nav_menu_name')
                        ->groupby('nav_header_id')
                        ->get();
                $menu2 = DB::table('tbl_nav_user as a')
                        ->select('b.nav_header_id', 'b.nav_menu_name', 'b.nav_menu_url')
                        ->join('tbl_nav_menu as b', 'a.nav_menu_id', '=', 'b.nav_menu_id')
                        ->where('a.user_id', '=', $data[0]->user_id)
                        ->where('b.nav_header_id', '=', $menu1[0]->nav_header_id)
                        ->orderby('nav_menu_name')
                        ->get(); 
                //dd(DB::getQueryLog());                      

                Session::put('url', $menu2[0]->nav_menu_url);
                Session::put('name', $menu2[0]->nav_menu_name);
                Session::put('nav_header_id', $menu1[0]->nav_header_id);
                Session::put('full_name', $data[0]->full_name);
                Session::put('user_id', $data[0]->user_id);
                Session::put('LOGIN',TRUE);                        

                var_dump($menu2);
                
                return view('home',  ['menu1' => $menu1, 'menu2' => $menu2]);
            }else{
                session::flash('error','Wrong username or password1');
                return redirect('/');
            }
        }else{
            Session::flash('error', 'Wrong username or password2');
            return redirect('/');
        }
    }

    
    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }

    public function home() {
        $user = DB::table('tbl_user')->get();
        Session::flash('success', 'godeg');
        return view('home', ['user' => $user]);
    }

    public function password() {
        return view('profile/password');
    }
}
