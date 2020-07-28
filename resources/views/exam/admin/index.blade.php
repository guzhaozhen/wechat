<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>微商城- 用户管理</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse" role="navigation">
	<div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">开发库存管理系统</a>
    </div>
    <div>
        <ul class="nav navbar-nav">
            @if(session('admin')->role_id!=2)
            <li class="active"><a href="{{url('/exam/admin/index')}}">用户管理</a></li>
            @endif
            <li><a href="{{url('/exam/product/index')}}">货物管理</a></li>
            <li><a href="{{url('/exam/record/index')}}">出入库记录管理</a></li>
            <li style="float:right"><a href="javascript:void(0);">【{{session('admin')->admin_name}}】</a></li>
			<li><a href="{{url('/logout')}}">退出</a></li>
        </ul>
    </div>
	</div>
</nav>

<center>
<h1><font color="red">用户管理--展示</font></h1><hr/>
 <span style="float:right;"><a href="{{url('exam/admin/create')}}">添加</a></span>
</center>

<form action="">
    <input type="text" name="admin_name" value="{{$admin_name}}">管理员名称
    <select name="role_id">
				<option value="">--请选择--</option>
				<option value="1" @if($role_id==1) selected @endif>库管主管</option>
                <option value="2" @if($role_id==2) selected @endif>普通库管</option>
	</select>
    <button>搜索</button>
</form>
<table class="table table-striped">
	<caption>用户管理</caption>
	<thead>
		<tr>
			<th>管理员ID</th>
			<th>管理员名称</th>
            <th>管理员角色</th>
            <th>管理员头像</th>
            <th>操作</th>
		</tr>
	</thead>
	<tbody>
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

	</tbody>
</table>
<script>
    /**ajax无刷新分页 */
    $(document).on('click','.page-item a',function(){
        // alert(11);
        var url = $(this).attr('href');
        $.get(url,function(res){
            // alert(res);
            $('tbody').html(res);
        });
        return false;
    })

    /**ajax删除 */
    $('.btn-danger').click(function(){
        // alert(111);
        var admin_id = $(this).attr('id');

        if(confirm("您确定删除?")){
                $.get('destroy/'+admin_id,function(res){
                // alert(res);
                if(res.code==1){
                    alert(res.msg);
                    location.href="{{url('exam/admin/index')}}";
                }
            },'json');
        }
    })



</script>

</body>
</html>

