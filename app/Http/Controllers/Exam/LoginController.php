<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class LoginController extends Controller
{
    public function index(){
        return view('exam.admin.login');
    }

    public function logindo(){
        $post = request()->except('_token');
        $admin = Admin::where('admin_name',$post['admin_name'])->first();

        if(!$admin){
            return redirect('exam/admin/login')->with('msg','用户名或密码错误');
        }

        if(decrypt($admin->admin_pwd)!=$post['admin_pwd']){
            return redirect('exam/admin/login')->with('msg','用户名或密码错误');
        }

        session(['admin'=>$admin]);
        // dump($res);
        
        return redirect('wexin/create');

    }
}
