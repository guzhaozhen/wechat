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

<center>
<h1><font color="red">货物管理--展示</font></h1><hr/>
 <span style="float:right;"><a href="{{url('exam/product/create')}}">添加</a></span>
</center>

<form action="">
    <input type="text" name="pro_name" value="{{$pro_name}}">货物名称
    <button>搜索</button>
</form>
<table class="table table-striped">
	<caption>用户管理</caption>
	<thead>
		<tr>
			<th>货物ID</th>
			<th>货物名称</th>
            <th>货物图</th>
            <th>当前库存量</th>
            <th>操作</th>
		</tr>
	</thead>
	<tbody>
        @foreach($goodsInfo as $k=>$v)
		<tr @if($k%2==0) class="active" @else class="success" @endif>
            <td>{{$v->r_id}}</td>
			<td>{{$v->pro_name}}</td>
            <td>
                @if($v->pro_img)
				<img src="{{env('UPLOADS_URL')}}{{$v->pro_img}}" height="50px" width="50px">
				@endif
            </td>
            <td>{{$v->pro_number}}</td>
            <td>
                <a class="btn btn-primary" href="{{url('/exam/product/stock/1/'.$v->pro_id)}}">入库</a>|
                <a class="btn btn-danger" href="{{url('/exam/product/stock/2/'.$v->pro_id)}}">出库</a>
            </td>
		</tr>
        @endforeach
        <tr>
			<td colspan=5 align="center">{{$goodsInfo->appends(['pro_name'=>$pro_name])->links()}}</td>
		</tr>

	</tbody>
</table>
<script>
    /**ajax无刷新分页 */
   $(document).on('click','.page-item a',function(){
       var url = $(this).attr('href');
       
       $.get(url,function(res){
            // alert(res);
            $('tbody').html(res);
       })

       return false;
   })

    /**ajax删除 */
    
   


</script>

</body>
</html>

