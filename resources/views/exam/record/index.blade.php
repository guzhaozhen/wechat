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
                <li><a href="{{url('/exam/product/index')}}">货物管理</a></li>
                <li class="active"><a href="{{url('/exam/record/index')}}">出入库记录管理</a></li>
                <li style="float:right"><a href="javascript:void(0);">【{{session('admin')->admin_name}}】</a></li>
                <li><a href="{{url('/logout')}}">退出</a></li>
            </ul>
        </div>
    </div>
</nav>

<center>
    <h1><font color="red">出入库记录管理--展示</font></h1><hr/>
    <span style="float:right;"><a href="{{url('exam/product/create')}}">添加</a></span>
</center>


<table class="table table-striped">
    <caption>出入库记录管理</caption>
    <thead>
    <tr>
        <th>ID</th>
        <th>操作用户</th>
        <th>货物名称</th>
        <th>操作时间</th>
        <th>操作类型</th>
        <th>出入库数量</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($log as $k=>$v)
        <tr @if($k%2==0) class="active" @else class="success" @endif>
            <td>{{$v->r_id}}</td>
            <td>{{$v->admin_id}}</td>
            <td>{{$v->pro_id}}</td>
            <td>{{date("Y-m-d H:i:s",$v->addtime)}}</td>
            <td>{{$v->types}}</td>
            <td>{{$v->number}}</td>
            <td>
                <a class="btn btn-primary" href="{{url('/exam/product/stock/1/'.$v->pro_id)}}">入库</a>|
                <a class="btn btn-danger" href="{{url('/exam/product/stock/2/'.$v->pro_id)}}">出库</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


</body>
</html>

