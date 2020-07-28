<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加素材</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<center>
    <h1>添加素材</h1><hr/>
</center>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="{{url('wexin/store')}}">
    @csrf
    <div class="form-group">
        <label class="col-sm-2 control-label">素材名称</label>
        <div class="col-sm-10">
            <input class="form-control" id="focusedInput" type="text" name="m_name">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">媒体格式</label>
        <div class="col-sm-10">
            <select name="type">
                <option value="">--请选择--</option>
                <option value="image">图片</option>
                <option value="video">视频</option>
                <option value="voice">语音</option>
                <option value="thumb">缩略图</option>

            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">素材类型</label>
        <div class="col-sm-10">
            <select name="t_id">
                <option value="">--请选择--</option>
                @foreach($typeInfo as $v)
                <option value="{{$v->t_id}}">{{$v->t_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">素材文件</label>
        <div class="col-sm-10">
            <input class="form-control" id="focusedInput" type="file" name="m_img">
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

