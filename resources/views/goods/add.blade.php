@extends('layouts.layout')

@section('title' ) {{$title}} @endsection

@section('content')
    <form class="layui-form" lay-filter="goods">
        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <li class="layui-this">基本信息</li>
                <li>商品基本属性</li>
                <li>商品销售属性</li>
            </ul>
            <div class="layui-tab-content" style="height: 100px;">
                <!--基本信息START-->
                <div class="layui-tab-item layui-show" >
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品名称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="goods_name" lay-verify="required" autocomplete="off" placeholder="请输入商品名称" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">品牌</label>
                        <div class="layui-input-inline">
                            <select name="brand_id" lay-verify="required">
                                <option value="">--请选择--</option>
                                @foreach($brand_data as $k => $v)
                                    <option value="{{$v->brand_id}}">{{$v->brand_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">分类</label>
                        <div class="layui-input-inline">
                            <select name="cate_id" lay-filter="category" lay-verify="required">
                                <option value="">--请选择--</option>
                                @foreach($data as $k => $v)
                                    @if($v->level == 2 )
                                        <option value="{{$v->cate_id}}">{!! str_repeat('&nbsp;&nbsp;' ,$v->level*4) !!}{{$v->cate_name}}</option>
                                    @else
                                        <option value="{{$v->cate_id}}" disabled>{!! str_repeat('&nbsp;&nbsp;' ,$v->level*4) !!}{{$v->cate_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">本店价格</label>
                            <div class="layui-input-inline">
                                <input type="text" name="goods_selfprice" lay-verify="required|number" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">市场价格</label>
                            <div class="layui-input-inline">
                                <input type="text" name="goods_marketprice" lay-verify="required|number" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否新品</label>
                        <div class="layui-input-block">
                            <input type="radio" name="goods_new" value="1" title="是" checked="">
                            <input type="radio" name="goods_new" value="0" title="否">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否精品</label>
                        <div class="layui-input-block">
                            <input type="radio" name="goods_best" checked value="1" title="是">
                            <input type="radio" name="goods_best" value="0" title="否">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否热卖</label>
                        <div class="layui-input-block">
                            <input type="radio" name="goods_hot" checked value="1" title="是">
                            <input type="radio" name="goods_hot" value="0" title="否">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">商品库存</label>
                            <div class="layui-input-inline">
                                <input type="number" name="goods_stock" lay-verify="required|number" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">商品积分</label>
                            <div class="layui-input-inline">
                                <input type="text" name="goods_score" lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <input type="hidden" id="mylogo" name="goods_goods_img">
                            <label class="layui-form-label">商品图片</label>
                            <button type="button" class="layui-btn" id="myload">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <input type="hidden" id="big_img" name="goods_big_imgs">
                            <input type="hidden" id="mid_img" name="goods_mid_imgs">
                            <input type="hidden" id="small_img" name="goods_small_imgs">
                            <label class="layui-form-label">轮播图</label>
                            <button type="button" class="layui-btn" id="myloads">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">编辑器</label>
                        <div class="layui-input-block">
                            <textarea id="demo" name="desc" style="display: none;"></textarea>
                            <script>
                                var layedit;
                                var index;
                                layui.use('layedit', function(){
                                    layedit = layui.layedit;
                                    layedit.set({
                                        uploadImage: {
                                            url: '{:url("Goods/goodsUpLoad",[\'type\' => 3])}' //接口url
                                            ,type: 'post' //默认post
                                        }
                                    });
                                    index = layedit.build('demo',{
                                        height: 180 //设置编辑器高度
//                      ,tool: ['left', 'center', 'right', '|', 'face']
                                    }); //建立编辑器
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <!-- 基本属性START -->
                <div class="layui-tab-item" id="basic">
                    <span style="color: red">请先选择分类</span>
                </div>
                <!-- 销售属性START -->
                <div class="layui-tab-item" id="sale">
                    <span style="color: red">请先选择分类</span>
                </div>
                <!-- 销售属性END -->
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


@endsection

@section('footer')
    <script>
        $(function () {
            layui.use( ['form','layer','upload','table'] , function () {
                var form = layui.form;
                var layer = layui.layer;
                var upload = layui.upload;
                var table = layui.table;

                //监听提交
                form.on('submit(*)',function(data){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:'/goods/add',
                        data:data.field,
                        type:'post',
                        dataType:'json',
                        success:function (data) {
                            layer.confirm(data.msg, {
                                btn: ['确定'] //可以无限个按钮
                            }, function(index, layero) {
                                //按钮【按钮一】的回调
                                if(data.status == 1000){
                                    location.href='/category/list'
                                }
                                layer.close(index);

                            })
                        }
                    });
                    return false;
                })

                //分类选择   基本 销售表单获取数据
                form.on('select(category)' , function (data) {
                    var category_id = data.value;
                    //基本属性
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:'/attr/basic/select',
                        type:'post',
                        data:{category_id:category_id},
                        datatype:'json',
                        success:function (data) {
                            if(data.status == 1000){
                                var _str = '';
                                $.each(data.data , function (i , val) {
                                    _str += '<div class="layui-form-item">' +
                                        '<label class="layui-form-label">'+val.attr_name+'</label>'+
                                        '<div class="layui-input-inline">';
                                    if(val.is_son == 1){
                                        _str += ' <select name="basic['+val.basic_id+']"  lay-verify="required" >'+
                                            '<option value="">请选择</option>';
                                        $.each(val.son , function (ii , value) {
                                            _str += '<option value="'+value.basic_value_id+'">'+value.attr_value+'</option>';
                                        })
                                        _str += '</select>';
                                    }else{
                                        _str += '<input type="text" name="basic['+val.basic_id+']" lay-verify="required" autocomplete="off" placeholder="请输入属性值" class="layui-input">'
                                    }
                                    _str += '</div></div>';

                                })
                                $('#basic').html(_str);
                                form.render();
                            }
                        }
                    });
                    //销售属性
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:'/attr/sale/select',
                        type:'post',
                        data:{category_id:category_id},
                        datatype:'json',
                        success:function (data) {
                            var _str = '';
                            $.each(data.data , function (i , val) {
                                _str += '<div class="layui-form-item" >'+
                                        '<div class="layui-input-block" style="margin-left: 2%">'+
                                        '<input type="checkbox" lay-filter="parent" name="parent[]" title="'+val.attr_name+'"  value="'+val.sale_id+'" lay-skin="primary" >' +
                                        '</div>'+
                                        '<div class="layui-input-block" style="margin-left: 4%">';
                                $.each(val.son , function (ii , value) {
                                    _str += '<input type="checkbox" lay-filter="son" name="son[]" title="'+value.attr_value+'" value="'+value.sale_value_id+'" lay-skin="primary"  parent_id="'+val.sale_id+'">';
                                })
                                _str += '</div><hr/></div>';

                            })
                            _str += '<div>'+
                                    '<table class="layui-table" lay-filter="test">' +
                                    '<thead></thead><tbody></tbody>' +
                                    '</table>' +
                                    '</div>' +
                                    '</form>';
                            $('#sale').html(_str);
                            form.render();
                        }
                    });
                })

                form.on('checkbox(parent)', function(data){
                    if( data.elem.checked == true ){
                        data.othis.parents('.layui-input-block').next().find('input').prop('checked',true);
                        form.render();
                    }else{
                        data.othis.parents('.layui-input-block').next().find('input').prop('checked',false);
                        form.render();
                    }
                    showSku();
                });
                
                form.on('checkbox(son)', function(data){
                    if( data.elem.checked == true ){
                        data.othis.parents('.layui-input-block').prev().find('input').prop('checked',true);
                        form.render();
                    }else{

                        var mark = 0;
                        //获取同级的所有二级菜单是否有选中的，有选中的化，让父级还是选中的状态
                        data.othis.parent('.layui-input-block').find('input').each(function(){
                            if( $(this).prop('checked') == true ){
                                mark = 1;
                            }
                        });
                        if( mark == 1 ){
                            data.othis.parents('.layui-input-block').prev().find('input').prop('checked',true);
                            form.render();
                        }else{
                            data.othis.parents('.layui-input-block').prev().find('input').prop('checked',false);
                            form.render();
                        }
                    }
                    showSku();
                });

                // 笛卡尔积算法
                function descartes(  list )
                {
                    //parent上一级索引;count指针计数
                    var point  = {};

                    var result = [];
                    var pIndex = null;
                    var tempCount = 0;
                    var temp   = [];

                    //根据参数列生成指针对象
                    for(var index in list)
                    {
                        if(typeof list[index] == 'object')
                        {
                            point[index] = {'parent':pIndex,'count':0}
                            pIndex = index;
                        }
                    }

                    //单维度数据结构直接返回
                    if(pIndex == null)
                    {
                        return list;
                    }

                    //动态生成笛卡尔积
                    while(true)
                    {
                        for(var index in list)
                        {
                            tempCount = point[index]['count'];
                            temp.push(list[index][tempCount]);
                        }

                        //压入结果数组
                        result.push(temp);
                        temp = [];

                        //检查指针最大值问题
                        while(true)
                        {
                            if(point[index]['count']+1 >= list[index].length)
                            {
                                point[index]['count'] = 0;
                                pIndex = point[index]['parent'];
                                if(pIndex == null)
                                {
                                    return result;
                                }

                                //赋值parent进行再次检查
                                index = pIndex;
                            }
                            else
                            {
                                point[index]['count']++;
                                break;
                            }
                        }
                    }
                }

                // 组合货品
                function showSku(){

                    // 先获取表头,拼装表头
                    var table_head = "<tr><td>商品名称</td>";
                    var head_arr = [];
                    var i =0;
                    $('[name^=parent]').each(function(){
//            console.log($(this).prop('checked'));
                        if( $(this).prop('checked') == true ){
                            head_arr[i] = $(this).attr('title');
                            table_head +='<td>'+$(this).attr('title')+'</td>' ;
                        }
                        i++;
                    });
                    table_head += "<td>库存</td>";
                    table_head += "<td>价格</td>";
                    table_head += "<td>操作</td>";
                    table_head += "</tr>";
                    $('.layui-table thead').html(table_head);

                    // 拼装货品的tr和td
                    var body_arr = [];
                    var j = 0;
                    $('[name^=parent]').each(function(){
                        if( $(this).prop('checked') == true ){
                            body_arr[j] = new Array();
                            var k = 0;
                            $(this).parents('.layui-input-block').next().find('input').each(function(){
                                if( $(this).prop('checked') == true ){
                                    body_arr[j][k] = $(this).attr('parent_id')+'|'+
                                        $(this).attr('title')
                                        + '|' +$(this).val();
                                    k++;
                                }
                            })
                            j++;
                        }
                    });
                    var result = descartes(body_arr);
                    var product_name = $('[name=goods_name]').val();


                    //console.log( result );

                    // z组合货品的名称
                    var table_body = '';
                    console.log(result);
                    for( var i in result ){
                        var sku_name = product_name;
                        table_body += '<tr>';
                        var attr_value='';
                        for( var j in result[i]){
                            var attr = result[i][j].split( '|' );
                            if( sku_name == product_name ){
                                sku_name +=  '-' + attr[1];
                            }else{
                                sku_name +=  '-' + attr[1];
                            }
                            attr_value += attr[0]+'|'+attr[2]+',';
                        }
                        // 货品的名称
                        table_body += '<td>'+sku_name+
                            '<input type="hidden" name="sku[sku][]" value="'+attr_value+'">' +
                            '<input type="hidden" name="sku[sku_name][]" value="'+sku_name+'"></td>';

                        // 货品的属性
                        for( var j in result[i]){
                            var attr = result[i][j].split( '|' );
                            table_body += '<td>'+attr[1]+'</td>';
                        }

                        table_body += '<td><input type="text" name="sku[goods_stock][]" ' +
                            'lay-verify="required" value="10" autocomplete="off" placeholder="请输入库存" ' +
                            'class="layui-input"></td>';
                        table_body += '<td><input type="text" name="sku[goods_price][]" ' +
                            'lay-verify="required"  value="2999" autocomplete="off" placeholder="请输入价格" ' +
                            'class="layui-input"></td>';
                        table_body += '<td>操作</td>';
                        table_body +='</tr>';
                    }

                    $('.layui-table tbody').html(table_body)

                }
            });
        })
    </script>
@endsection