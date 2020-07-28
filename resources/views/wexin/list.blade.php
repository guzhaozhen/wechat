<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <titl>微信素材管理</titl></title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>


<center>
    <h1>微信素材管理--展示</h1><hr/>
    <span style="float:right;"><a href="{{url('/wexin/create')}}">添加</a></span>
</center>

<table class="table">
    <caption>微信素材管理</caption>
    <thead>
    <tr>
        <th>素材编号</th>
        <th>素材名称</th>
        <th>媒体格式</th>
        <th>素材类型</th>
        <th>素材展示</th>
        <th>微信服务器ID</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($mediaInfo as $k=>$v)
        <tr @if($k%2==0) class="active" @else class="success" @endif>
            <td>{{$v->m_id}}</td>
            <td>{{$v->m_name}}</td>
            <td>{{$v->type}}</td>
            <td>{{$v->t_name==1?'永久素材':'临时素材'}}</td>
            <td>
                @if($v->m_img)
                    <img src="{{env('IMAGE_URL')}}{{$v->m_img}}" height="50px" width="50px">
                @endif
            </td>
            <td>{{$v->media_id}}</td>
            <td>{{date("Y-m-d H:i:s",$v->addtime)}}</td>
            <td></td>
            <td>
                <a class="btn btn-primary" href="{{url('wexin/edit/'.$v->m_id)}}">编辑</a>|
                <a class="btn btn-danger" href="javascript:void(0)" id={{$v->m_id}}>删除</a>
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan=8 align="center">{{$mediaInfo->links()}}</td>
    </tr>
    </tbody>
</table>
</body>

</html>


