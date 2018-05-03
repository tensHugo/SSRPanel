@extends('user.layouts')

@section('css')
    <style type="text/css">
        .ticker {
            background-color: #fff;
            margin-bottom: 20px;
            border: 1px solid #e7ecf1!important;
            border-radius: 4px;
            -webkit-border-radius: 4px;
        }
        .ticker ul {
            padding: 0;
        }
        .ticker li {
            list-style: none;
            padding: 15px;
        }
    </style>

    <style type="text/css">
        #lottery{width:574px;height:584px;margin:20px auto;background:url(/assets/images/bg.jpg) no-repeat;padding:50px 55px;}
        #lottery table td{width:142px;height:142px;text-align:center;vertical-align:middle;font-size:24px;color:#333;font-index:-999}
        #lottery table td a{width:284px;height:284px;line-height:150px;display:block;text-decoration:none;}
        #lottery table td.active{background-color:#ea0000;}

    </style>
@endsection
@section('title', trans('home.panel'))
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top:0;">
        <!-- BEGIN PAGE BASE CONTENT -->
        @if (Session::has('successMsg'))
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button>
                {{Session::get('successMsg')}}
            </div>
        @endif
        @if($notice)
            <div class="alert alert-success">
                <i class="fa fa-bell-o"></i>
                <button class="close" data-close="alert"></button>
                <a href="{{url('user/article?id=') . $notice->id}}" class="alert-link" target="_blank"> {{$notice->title}} </a>
            </div>
        @endif
        <div class="row">
            <div class="col-md-8">
                <div class="alert alert-danger">
                    {{trans('home.ratio_tips')}}
                    <button class="btn btn-sm red" onclick="subscribe()"> {{trans('home.subscribe_button')}} </button>
                </div>
                <div class="row widget-row">
                    @if(!$nodeList->isEmpty())
                        @foreach($nodeList as $node)
                            <div class="col-md-4">
                                <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                    <h4 class="widget-thumb-heading">{{$node->name}}</h4>
                                    <div class="widget-thumb-wrap">
                                        <div style="float:left;display: inline-block;padding-right:15px;">
                                            @if($node->country_code)
                                                <img src="{{asset('assets/images/country/' . $node->country_code . '.png')}}"/>
                                            @else
                                                <img src="{{asset('/assets/images/country/un.png')}}"/>
                                            @endif
                                        </div>
                                        <div class="widget-thumb-body">
                                            <span class="widget-thumb-subtitle"><a data-toggle="modal" href="#txt_{{$node->id}}">{{$node->server}}</a>&nbsp&nbsp
                                              <!--动态显示节点在线图标-->
                                              @if($node->ss_status==1 and $node->status==1)
                                                  <span style="color:LimeGreen" title="节点在线"><i class="fa fa-cloud-upload"></i></span>
                                              @elseif($node->status==0)
                                                  <span style="color:yellow" title="节点维护中"><i class="fa fa-cloud-upload"></i></span>
                                              @else
                                                  <span style="color:red" title="节点离线"><i class="fa fa-cloud-upload"></i></span>
                                              @endif
                                            </span>
                                            <span class="widget-thumb-body-stat">
                                                <a class="btn btn-sm green btn-outline copy" href="javascript:show('链接已复制到剪切板，可以直接剪切板导入');" data-clipboard-text="{{$node->ssr_scheme. '<br/><br/>' . $node->ss_scheme}}" title="复制SSR/SS链接"> <i class="fa fa-paper-plane"></i> </a>
                                                <a class="btn btn-sm green btn-outline" data-toggle="modal" href="#qrcode_{{$node->id}}" title="显示二维码"> <i class="fa fa-qrcode"></i> </a>
                                               <!-- <a class="btn btn-sm green btn-outline" href="javascript:show('结算比例：{{$node->traffic_rate}}');" title="显示流量比例"> <i class="fa fa-exchange"></i> </a> -->
                                               <a class="btn btn-sm green btn-outline" href="{{$node->ssr_scheme}}" title="SSR链接"> <i class="fa fa-link"></i> </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="portlet box red">
                    <div class="portlet-title">
                        <div class="caption">{{trans('home.account_info')}}</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse" data-original-title="" title="折叠"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <p class="text-muted"> {{trans('home.account_level')}}：{{$info['levelName']}} </p>
                        <p class="text-muted">
                            {{trans('home.account_balance')}}：{{$info['balance']}}
                            <span class="badge badge-danger">
                                <a href="javascript:;" data-toggle="modal" data-target="#charge_modal" style="color:#FFF;">充值</a>
                            </span>
                            &ensp;&ensp;{{trans('home.account_score')}}：{{$info['score']}}
                            <span class="badge badge-danger">
                                <a href="javascript:;" data-toggle="modal" data-target="#exchange_modal" style="color:#FFF;">兑换</a>
                            </span>
                        </p>
                        <p class="text-muted"> {{trans('home.account_status')}}：{{$info['enable'] ? '正常' : '禁用'}} </p>
                        <p class="text-muted"> {{trans('home.account_expire')}}：{{date('Y-m-d 0:0:0') > $info['expire_time'] ? '已过期' : $info['expire_time']}} </p>
                        <p class="text-muted"> {{trans('home.account_last_usage')}}：{{empty($info['t']) ? '从未使用' : date('Y-m-d H:i:s', $info['t'])}} </p>
                        <p class="text-muted"> {{trans('home.account_last_login')}}：{{empty($info['last_login']) ? '未登录' : date('Y-m-d H:i:s', $info['last_login'])}} </p>
                        <p class="text-muted">
                            {{trans('home.account_bandwidth_usage')}}：{{$info['usedTransfer']}} （{{$info['totalTransfer']}}）@if($info['traffic_reset_day']) &ensp;&ensp;每月{{$info['traffic_reset_day']}}日自动重置流量 @endif
                            <div class="progress progress-striped active" style="margin-bottom:0;" title="{{trans('home.account_total_traffic')}} {{$info['totalTransfer']}}，{{trans('home.account_usage_traffic')}} {{$info['usedTransfer']}}">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{$info['usedPercent'] * 100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$info['usedPercent'] * 100}}%">
                                    <span class="sr-only"> {{$info['usedTransfer']}} / {{$info['totalTransfer']}} </span>
                                </div>
                            </div>
                        </p>
                    </div>
                </div>
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">{{trans('home.article_title')}}</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse" data-original-title="" title="折叠"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        @foreach($articleList as $k => $article)
                            <p class="text-muted">
                                [{{date('m/d', strtotime($article->created_at))}}] <a href="{{url('user/article?id=') . $article->id}}" target="_blank"> {{$article->title}} </a>
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div id="charge_modal" class="modal fade" tabindex="-1" data-focus-on="input:first" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">余额充值</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" style="display: none;" id="charge_msg"></div>
                        <form action="#" method="post" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="charge_type" class="col-md-4 control-label">充值方式</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="charge_type" id="charge_type">
                                            <option value="101" selected>支付宝</option>
                                            <option value="102" >微信</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="charge_coupon" class="col-md-4 control-label" id="chongzhi">金额 </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="charge_coupon" id="charge_coupon" placeholder="充值金额">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">关闭</button>
                        <button type="button" class="btn red btn-outline" onclick="return charge();">充值</button>
                       
                    </div>
                </div>
            </div>
        </div>
        <div id="exchange_modal" class="modal fade" tabindex="-1" data-focus-on="input:first" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">兑换流量 </h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info" id="msg">您有 {{$info['score']}} 积分，共计可兑换 {{$info['score']}}M 免费流量。</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">关闭</button>
                        <button type="button" class="btn red btn-outline" onclick="return exchange();">立即兑换</button>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($nodeList as $node)
            <div class="modal fade draggable-modal" id="txt_{{$node->id}}" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">配置信息</h4>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" rows="10" readonly="readonly">{{$node->txt}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="qrcode_{{$node->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog @if(!$node->compatible) modal-sm @endif">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">请使用客户端扫描二维码</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @if ($node->compatible)
                                    <div class="col-md-6">
                                        <div style="font-size:16px;text-align:center;padding-bottom:10px;"><span>SSR</span></div>
                                        <div id="qrcode_ssr_img_{{$node->id}}"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div style="font-size:16px;text-align:center;padding-bottom:10px;"><span>SS</span></div>
                                        <div id="qrcode_ss_img_{{$node->id}}"></div>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <div style="font-size:16px;text-align:center;padding-bottom:10px;"><span>SSR</span></div>
                                        <div id="qrcode_ssr_img_{{$node->id}}"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
    <script src="/assets/global/plugins/jquery-qrcode/jquery.qrcode.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/js/layer/layer.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></script>
    <script type="text/javascript">
    	$("#charge_type").change(function(){
            var checkValue=$("#charge_type").val();
            if(checkValue=='101' || checkValue=='102'){
            	$("#chongzhi").text("充值金额");
            	 $('#charge_coupon').attr('placeholder',"请输入充值金额");
            	 $("#kuaifaka").hide();
            }else{
            	$("#chongzhi").text("充值码");
            	$('#charge_coupon').attr('placeholder',"充值码点击最右侧按钮购买");
            	$("#kuaifaka").show();
            }
        });
    		
      //初始化剪切板类
       new Clipboard('.copy');
        // 充值
        function charge() {
        	
            var _token = '{{csrf_token()}}';
            var charge_type = $("#charge_type").val();
            var charge_coupon = $("#charge_coupon").val();

            if (charge_type == '1' && (charge_coupon == '' || charge_coupon == undefined)) {
                $("#charge_msg").show().html("券码不能为空");
                $("#charge_coupon").focus();
                return false;
            }else if(charge_type == '101' && (charge_coupon == '' || charge_coupon == undefined)){
                $("#charge_msg").show().html("充值金额不能为空");
                $("#charge_coupon").focus();
                return false;
            }else if(charge_type == '102' && (charge_coupon == '' || charge_coupon == undefined)){
                $("#charge_msg").show().html("充值金额不能为空");
                $("#charge_coupon").focus();
                return false;
            }else if(charge_type == '101' || charge_type == '102'){
            	window.open('/api/qypay_send?bank_type='+ charge_type +'&totalAmount=' + charge_coupon + '&user_id=' + "{{$info['id']}}" + "&url=" + window.location.href);
            	$("#charge_msg").show().html("已跳转付款页面，付款成功后请自行刷新");
                $("#charge_coupon").focus();
            	return false;
            }

            $.ajax({
                url:'{{url('user/charge')}}',
                type:"POST",
                data:{_token:_token, coupon_sn:charge_coupon},
                beforeSend:function(){
                    $("#charge_msg").show().html("充值中...");
                },
                success:function(ret){
                    if (ret.status == 'fail') {
                        $("#charge_msg").show().html(ret.message);
                        return false;
                    }

                    $("#charge_modal").modal("hide");
                    window.location.reload();
                },
                error:function(){
                    $("#charge_msg").show().html("请求错误，请重试");
                },
                complete:function(){}
            });
        }

        // 积分兑换流量
        function exchange() {
            $.ajax({
                type: "POST",
                url: "{{url('user/exchange')}}",
                async: false,
                data: {_token:'{{csrf_token()}}'},
                dataType: 'json',
                success: function (ret) {
                    layer.msg(ret.message, {time:1000}, function() {
                        if (ret.status == 'success') {
                            window.location.reload();
                        }
                    });
                }
            });

            return false;
        }
    </script>

    <script type="text/javascript">
        var UIModals = function () {
            var n = function () {
                @foreach($nodeList as $node)
                    $("#txt_{{$node->id}}").draggable({handle: ".modal-header"});
                    $("#qrcode_{{$node->id}}").draggable({handle: ".modal-header"});
                @endforeach
            };

            return {
                init: function () {
                    n()
                }
            }
        }();

        jQuery(document).ready(function () {
            UIModals.init()
        });

        // 循环输出节点scheme用于生成二维码
        @foreach ($nodeList as $node)
            $('#qrcode_ssr_img_{{$node->id}}').qrcode("{{$node->ssr_scheme}}");
            $('#qrcode_ss_img_{{$node->id}}').qrcode("{{$node->ss_scheme}}");
        @endforeach

        // 节点订阅
        function subscribe() {
            window.location.href = '{{url('/user/subscribe')}}';
        }

        // 显示加密、混淆、协议 提示信息
        function show(txt) {
            layer.msg(txt);
        }
         
    </script>
@endsection
