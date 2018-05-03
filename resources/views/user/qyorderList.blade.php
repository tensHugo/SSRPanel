@extends('user.layouts')

@section('css')
    <link href="/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <style>
        .fancybox > img {
            width: 75px;
            height: 75px;
        }
    </style>
@endsection
@section('title', trans('home.panel'))
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top: 0;">
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="note note-info">
                    <p> 如有待支付充值记录，请直接点击付款按钮进行支付或点击删除按钮作废。充值请到首页右侧账号信息栏 </p>
                </div>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-wallet font-dark"></i>
                            <span class="caption-subject bold">充值记录</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> 充值单号 </th>
                                        <th>提交金额</th>
                                        <th> 实付金额 </th>
                                        <th> 实付方式 </th>
                                        <th> 支付流水号 </th>
                                        <th> 提交时间 </th>
                                        <th> 支付时间 </th>
                                        <th> 支付状态 </th>
                                        <th> 操作 </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($qyorderList->isEmpty())
                                    <tr>
                                        <td colspan="5">{{trans('home.invoice_table_none')}}</td>
                                    </tr>
                                @else
                                    @foreach($qyorderList as $key => $order)
                                        <tr class="odd gradeX">
                                            <td>{{$order->pay_id}}</td>
                                            <td>￥{{$order->money}}</td>
                                            <td>￥{{$order->price}}</td>
                                                @if($order->type == 101)
                                                    <td> 支付宝 </td>
                                                @elseif($order->type == 102)
                                                   <td> 微信 </td>
                                                @else
                                                   <td>未知 </td>
                                                @endif
                                            <td>{{$order->pay_tag}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{$order->pay_time}}</td>
                                           <td>
                                                @if($order->status == 1)
                                                    <span class="label label-info">支付成功</span>
                                                @elseif($order->status == 2)   
                                                    <span class="label label-warning">待支付</span>
                                                @elseif($order->status == 3)     
                                                    <span class="label label-danger">支付失败</span>
                                                 @elseif($order->status == 4)     
                                                    <span class="label label-danger">订单作废</span>    
                                                @endif
                                            </td>
                                            <td>
                                            	@if($order->status == 2)
                                            	    <button type="button" class="btn btn-sm green btn-outline" onclick="qypay('{{$order->type}}','{{$order->pay_id}}',{{$order->money}})">
                                                        <i class="glyphicon glyphicon-credit-card"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm red btn-outline" onclick="qydel({{$order->id}})">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </button>
                                                @endif    
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="dataTables_paginate paging_bootstrap_full_number pull-right">
                                    {{ $qyorderList->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
<script src="/js/layer/layer.js" type="text/javascript"></script>
    <script type="text/javascript">
        //发起支付
         function qypay(type,pid,money) {
            window.open('/api/qypay_send?bank_type=' + type + '&totalAmount=' + money + '&pid=' + pid + "&url=" + window.location.href);
        }
        
        //作废订单
        function qydel(oid) {
            layer.confirm('确定要作废该充值订单吗？', {icon: 2, title:'警告'}, function(index) {
                $.post("{{url('user/qyOrderDel')}}", {_token:'{{csrf_token()}}', oid:oid}, function (ret) {
                    layer.msg(ret.message, {time:1000}, function() {
                        if (ret.status == '1') {
                            window.location.reload();
                        }
                    });
                });

                layer.close(index);
            });
        }
        
    </script>
@endsection
