<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\User;

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

        $data = DB::table('tbl_user')
                ->select('user_id', 'user_photo', 'username', 'password', 'full_name', 'group_id', 'client_id', 'parent_user_id', 'timezone_id')
                ->where('active_status', '=', 1)
                ->where('username', '=', $username)
                ->limit(1)
                ->get();
        
        if(Hash::check($password, $data[0]->password)) {
            Session::put('full_name', $data[0]->full_name);
            Session::put('LOGIN',TRUE);
            return redirect('home');
        }else{echo 'babi';

            //return view('godeg', ['title' => 'a']);
            //return redirect('/');
        }
        //return redirect('/');
        /*$data = [
            'username'   => $r->input('txt_username'),
            'password'   => $r->input('txt_password')
        ];*/
        //Auth::attempt($data);
        //if(Auth::check()) {

            /*foreach($data as $a) {
                session(['full_name' => $a->full_name]);
            }*/
            //session(['username' => $data]);
            //Session::put('username', $username);
            //Session::save();
            //return redirect('home');
        //}else{
        //    return redirect('/');
        //}
        /*if(Hash::check($password, $data->password)) {
            return 'oke';
        }else{
            return 'no';
        }*/    
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
