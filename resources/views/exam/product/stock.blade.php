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

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="{{url('exam/product/delivery/'.$type.'/'.$goodsInfo->pro_id)}}">
	@csrf
    <div class="form-group">
		<label class="col-sm-2 control-label">货物名称</label>
		<div class="col-sm-10">
			{{$goodsInfo->pro_name}}
		</div>
	</div>
    <div class="form-group">
		<label class="col-sm-2 control-label">货物图</label>
		<div class="col-sm-10">
             @if($goodsInfo->pro_img)
				<img src="{{env('UPLOADS_URL')}}{{$goodsInfo->pro_img}}" height="50px" width="50px">
			 @endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">现有库存量</label>
		{{$goodsInfo->pro_number}}
	</div>

    @if($type==1)
    <div class="form-group">
		<label class="col-sm-2 control-label">新入库数量</label>
		<input  id="focusedInput" type="text" name="pro_number">
	</div>
    @else
    <div class="form-group">
		<label class="col-sm-2 control-label">出库数量</label>
		<input  id="focusedInput" type="text" name="pro_number">
	</div>
    @endif


    @if($type==1)
    <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">入库</button>
		</div>
	</div>
    @endif
    @if($type==2)
    <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">出库</button>
		</div>
	</div>
    @endif
</form>
</body>

</html>
