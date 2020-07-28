<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>留言管理</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<center>
    <h1><font color="red">留言管理--展示</font></h1><hr/>
</center>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="{{url('exam/message/store')}}">
    @csrf
    <div class="form-group">
        <label class="col-sm-2 control-label">留言内容</label>
        <div class="col-sm-10">
            <textarea name="u_content" cols="30" rows="5"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">发布</button>
        </div>
    </div>

</form>

访问量:{{$visitor}}

<form action="">
    姓名<input type="text" name="u_name" value="{{$u_name}}">
    <button>搜索</button>
</form>

<table class="table table-striped">
    <caption>留言管理</caption>
    <thead>
    <tr>
        <th>编号</th>
        <th>留言内容</th>
        <th>留言姓名</th>
        <th>时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($messageInfo as $k=>$v)
        <tr @if($k%2==0) class="active" @else class="success" @endif>
            <td>{{$v->u_id}}</td>
            <td>{{$v->u_content}}</td>
            <td>{{$v->u_name}}</td>
            <td>{{date("Y-m-d H:i:s",$v->addtime)}}</td>
            <td>
                <a class="btn btn-primary" href="{{url('/exam/message/edit/'.$v->u_id)}}">编辑</a>|
                <a class="btn btn-danger" href="javascript:void(0);" id="{{$v->u_id}}">删除</a>
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan=5 align="center">{{$messageInfo->appends(['u_name'=>$u_name])->links()}}</td>
    </tr>

    </tbody>
</table>
<script>
    /**ajax删除 */
    $(document).on('click','.btn-danger',function(){
        // alert(11);
        var id = $(this).attr('id');
        var obj = $(this);

        if(confirm("您确定删除吗?")){
            $.get('destroy/'+id,function(res){
                // alert(res);
                if(res.code=='1'){
                    location.href="{{url('exam/message/index')}}";
                    alert(res.msg);
                }
            },'json');
        }
    })
</script>
</body>
</html>

