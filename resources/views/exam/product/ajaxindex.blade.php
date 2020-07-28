@foreach($goodsInfo as $k=>$v)
		<tr @if($k%2==0) class="active" @else class="success" @endif>
			<td>{{$v->pro_id}}</td>
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