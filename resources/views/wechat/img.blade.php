<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加临时素材</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<center>
    <h1>添加临时素材</h1><hr/>
</center>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="{{url('wechat/uploadimg')}}">
    @csrf
    <div class="form-group">
        <label class="col-sm-2 control-label">上传图片</label>
        <div class="col-sm-10">
            <input class="form-control" id="focusedInput" type="file" name="img">
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

