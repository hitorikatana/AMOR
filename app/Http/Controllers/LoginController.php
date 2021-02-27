<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use View;
use App\User;
use App\Models\NavigationModel;
use Illuminate\Support\Facades\Route;
class LoginController extends Controller
{
    public function index() {
        $title      = 'Get AMOR';
        $username   = 'Username';
        $password   = 'Enter password';
        return view('login', ['title' => $title, 'username' => $username, 'password' => $password]);
    }


    protected $layout = "/";

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
                DB::enableQueryLog();
                /*$menu = DB::table('tbl_nav as y') ini kalau pakai 1 table
                        ->select("*",
                        DB::raw("(SELECT count(*) FROM tbl_nav_user x WHERE x.nav_id = y.nav_id AND user_id = $user_id) as ada"))
                        ->orderby('nav_name')
                        ->get();*/

                /*$menu = DB::table('tbl_nav as a') 1 table tapi innerjoin
                        ->select('a.nav_name', 'a.nav_icon', 'a.nav_url', 'b.nav_name')
                        ->leftJoin('tbl_nav as b', 'a.nav_id', '=', 'b.nav_id')
                        ->join('tbl_nav_user as c', 'b.nav_id', '=', 'c.nav_id')
                        ->where('c.user_id', '=', $data[0]->user_id)
                        ->orderby('nav_name')
                        ->get();*/
                    /*$menu = DB::table('tbl_nav_user as a')
                    ->select('b.nav_header_id','nav_header_icon','nav_menu_url', 'nav_header_name')
                    ->join('tbl_nav_menu as b', 'a.nav_menu_id', '=', 'b.nav_menu_id')
                    ->join('tbl_nav_header as c', 'b.nav_header_id', '=', 'c.nav_header_id')
                    ->where('user_id', '=', $user_id)
                    ->groupBy('nav_header_id')
                    ->orderBy('nav_menu_name')
                    ->get();

                    foreach($menu as $a) {
                        $submenu[$a->user_id] = DB::tabel('tbl_nav_user as a')
                        ->select('nav_header_id,nav_menu_name, nav_menu_url')
                        ->join('tbl_nav_menu as b', 'a.nav_menu_id', '=', 'b.nav_menu_id')
                        ->where('user_id', '=', $user_id)
                        ->where('nav_header_id', '=', $menu->nav_header_id)
                        ->get();
                    }*/

                //dd(DB::getQueryLog());

                //Session::put(['menu' => $menu]);
                //Session::put(['submenu' => $submenu]);
                //Session::put('url', $menu[0]->nav_menu_url);
                //Session::put('name', $menu[0]->nav_header_name);
                Session::put('full_name', $data[0]->full_name);
                Session::put('user_id', $data[0]->user_id);
                Session::put('LOGIN',TRUE);

                //$items = NavigationModel::tree();
                //Session::put(['items' => $items]);
                //$this->layout->content = View::make('master')->withItems($items);

                $menu = NavigationModel::with('parent')
                    //->join('tbl_nav_user as a','a.nav_id','=','tbl_nav.nav_id')
                    ->where('parent_id','=',0)
                    //->where('user_id','=',$data[0]->user_id)
                    ->get();
                //dd(DB::getQueryLog());
                Session::put(['menu'=> $menu]);
                return view('home', ['menu' => $menu]);
                //return redirect()->route('home', ['menu' => $menu]);
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
