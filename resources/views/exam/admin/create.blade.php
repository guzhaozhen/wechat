<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>管理员</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<!-- @if ($errors->any()) 
	<div class="alert alert-danger">
		<ul>@foreach ($errors->all() as $error) 
		<li>{{ $error }}</li>
		@endforeach
		</ul> 
	</div>
   @endif -->
<center>
<h1>管理员管理</h1><hr/>
<span style="float:right;"><a href="{{url('exam/admin/index')}}">管理员列表</a></span>
</center>
<b style="color:red">{{session('msg')}}</b>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="{{url('exam/admin/store')}}">
	@csrf
    <div class="form-group">
		<label class="col-sm-2 control-label">管理员名称</label>
		<div class="col-sm-10">
			<input class="form-control" id="focusedInput" type="text" name="admin_name">
			 <!-- 第二种验证方式 -->
			 <span style="color:red">{{$errors->first('admin_name')}}</span>
		</div>
	</div>
    <div class="form-group">
		<label class="col-sm-2 control-label">管理员密码</label>
		<div class="col-sm-10">
			<input class="form-control" id="focusedInput" type="password" name="admin_pwd">
			 <!-- 第二种验证方式 -->
			 <span style="color:red">{{$errors->first('admin_pwd')}}</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">确认密码</label>
		<div class="col-sm-10">
			<input class="form-control" id="focusedInput" type="password" name="admin_pwd_confirmation">
			<span style="color:red">{{$errors->first('admin_pwd_confirmation')}}</span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">管理员角色</label>
		<div class="col-sm-10">
			<select name="role_id">
				<option value="">--请选择--</option>
				<option value="1" slelected>库管主管</option>
                <option value="2">普通库管</option>
			</select>
			<span style="color:red">{{$errors->first('role_id')}}</span>
		</div>
	</div>

    <div class="form-group">
		<label class="col-sm-2 control-label">管理员头像</label>
		<div class="col-sm-10">
			<input class="form-control" id="focusedInput" type="file" name="admin_img">
		</div>
	</div>
    <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">添加</button>
		</div>
	</div>
</form>
</body>
<!-- <script>
	$(document).on('click','button',function(){
		// alert(11);
		var admin_name = $('input[name="admin_name"]').val();
		// alert(admin_name);

		$.post('admin/checkname','admin_name',function(res){
			alert(res);
		})

	})
</script> -->
</html>
