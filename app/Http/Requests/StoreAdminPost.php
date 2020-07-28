<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'admin_name' => 'required|unique:admin|regex:/^[\x{4e00}-\x{9fa5}\w]{2,12}$/u', 
            'admin_pwd' => 'required|alpha_dash|min:6',
            'admin_pwd_confirmation' => 'required|same:admin_pwd',
            'role_id'=>'required',
            
        ];
    }

    public function messages()
    {
        return [
            'admin_name.required'=>'管理员名称不能为空',
            'admin_name.unique' => '管理员名称已存在',
            'admin_name.regex'=>'管理员名称有中文、字母、下划线2-12位组成',
            'admin_pwd.required' => '管理员密码不能为空',
            'admin_pwd.alpha_dash' => '管理员密码由字母和数字，以及破折号和下划线组成',
            'admin_pwd.min' => '密码不能少于6位',
            'admin_pwd_confirmation.required' => '确认密码不能为空',
            'admin_pwd_confirmation.same' => '密码与确认密码必须保持一致',
            'role_id.required' => '角色不能为空',
        ];
    }
}
