<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>货物管理</title>
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
            <li><a href="{{url('/exam/admin/index')}}">用户管理</a></li>
            @endif
            <li class="active"><a href="{{url('/exam/product/index')}}">货物管理</a></li>
            <li><a href="{{url('/exam/record/index')}}">出入库记录管理</a></li>
            <li style="float:right"><a href="javascript:void(0);">【{{session('admin')->admin_name}}】</a></li>
			<li><a href="{{url('/logout')}}">退出</a></li>
        </ul>
    </div>
	</div>
</nav>
<!-- @if ($errors->any()) 
	<div class="alert alert-danger">
		<ul>@foreach ($errors->all() as $error) 
		<li>{{ $error }}</li>
		@endforeach
		</ul> 
	</div>
   @endif -->
<center>
<h1>货物管理</h1><hr/>
<span style="float:right;"><a href="{{url('exam/product/index')}}">货物管理列表</a></span>
</center>
<b style="color:red">{{session('msg')}}</b>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="{{url('exam/product/store')}}">
	@csrf
    <div class="form-group">
		<label class="col-sm-2 control-label">货物名称</label>
		<div class="col-sm-10">
			<input class="form-control" id="focusedInput" type="text" name="pro_name">
			 <!-- 第二种验证方式 -->
			 <span style="color:red">{{$errors->first('pro_name')}}</span>
		</div>
	</div>
    <div class="form-group">
		<label class="col-sm-2 control-label">货物图</label>
		<div class="col-sm-10">
			<input class="form-control" id="focusedInput" type="file" name="pro_img">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">当前库存量</label>
		<div class="col-sm-10">
			<input class="form-control" id="focusedInput" type="text" name="pro_number">
			<span style="color:red">{{$errors->first('pro_number')}}</span>
		</div>
	</div>
    <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">添加</button>
		</div>
	</div>

</form>
</body>

</html>
