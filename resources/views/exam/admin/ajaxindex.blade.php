@foreach($adminInfo as $k=>$v)
		<tr @if($k%2==0) class="active" @else class="success" @endif>
			<td>{{$v->admin_id}}</td>
			<td>{{$v->admin_name}}</td>
            <td>{{$v->role_id==1?'库管主管':'普通库管'}}</td>
            <td>
                @if($v->admin_img)
				<img src="{{env('UPLOADS_URL')}}{{$v->admin_img}}" height="50px" width="50px">
				@endif
            </td>
            <td>
                <a class="btn btn-primary" href="{{url('/exam/admin/edit/'.$v->admin_id)}}">编辑</a>|
                <a class="btn btn-danger" href="javascript:void(0);" id="{{$v->admin_id}}">删除</a>
            </td>
		</tr>
        @endforeach
        <tr>
			<td colspan=5 align="center">{{$adminInfo->appends(['admin_name'=>$admin_name,'role_id'=>$role_id])->links()}}</td>
		</tr>