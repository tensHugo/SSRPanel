@extends('admin.layouts')

@section('css')
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
@endsection
@section('title', '控制面板')
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top:0;">
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-credit-card font-dark"></i>
                            <span class="caption-subject bold uppercase">用户充值记录 </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-2 col-sm-2">
                                <input type="text" class="col-md-4 form-control input-sm" name="username" value="{{Request::get('username')}}" id="username" placeholder="用户名" onkeydown="if(event.keyCode==13){do_search();}">
                            </div>
                          <div class="col-md-2 col-sm-2">
                                <input type="text" class="col-md-4 form-control input-sm" name="pay_id" value="{{Request::get('pay_id')}}" id="pay_id" placeholder="充值单号" onkeydown="if(event.keyCode==13){do_search();}">
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <input type="text" class="col-md-4 form-control input-sm" name="pay_no" value="{{Request::get('pay_no')}}" id="pay_no" placeholder="支付流水号" onkeydown="if(event.keyCode==13){do_search();}">
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <button type="button" class="btn btn-sm blue" onclick="do_search();">查询</button>
                                <button type="button" class="btn btn-sm grey" onclick="do_reset();">重置</button>
                            </div>
                        </div>
                        <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column">
                                <thead>
                                <tr>
                                    <th> # </th>
                                    <th> 用户名 </th>
                                    <th> 订单ID </th>
                                    <th> 提交金额 </th>
                                    <th> 实际支付金额 </th>
                                    <th> 支付方式 </th>
                                    <th> 千应流水号 </th>
                                    <th> 支付平台流水号 </th>
                                    <th> 支付状态 </th>
                                    <th> 创建时间 </th>
                                    <th> 支付时间 </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if($list->isEmpty())
                                        <tr>
                                            <td colspan="8">暂无数据</td>
                                        </tr>
                                    @else
                                        @foreach($list as $vo)
                                            <tr class="odd gradeX">
                                                <td> {{$vo->id}} </td>
                                                <td> {{empty($vo->user) ? '【用户已删除】' : $vo->user->username}} </td>
                                                <td> {{$vo->pay_id}} </td>
                                                <td> {{$vo->money}} </td>
                                                <td> {{$vo->price}} </td>
                                                @if($vo->type == 101)
                                                    <td> 支付宝 </td>
                                                @elseif($vo->type == 102)
                                                   <td> 微信 </td> 
                                                @else
                                                   <td>未知</td>
                                                @endif   
                                                <td> {{$vo->pay_no}} </td>
                                                <td> {{$vo->pay_tag}} </td>
                                                <td>
                                                @if($vo->status == 1)
                                                    <span class="label label-info">支付成功</span>
                                                @elseif($vo->status == 2)   
                                                    <span class="label label-warning">待支付</span>
                                                @elseif($vo->status == 3)     
                                                    <span class="label label-danger">支付失败</span>
                                                 @elseif($vo->status == 4)     
                                                    <span class="label label-danger">订单作废</span>    
                                                @endif
                                                </td>    
                                                <td> {{$vo->created_at}} </td>
                                                <td> {{$vo->pay_time}} </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="dataTables_info" role="status" aria-live="polite">共 {{$list->total()}} 条记录</div>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <div class="dataTables_paginate paging_bootstrap_full_number pull-right">
                                    {{ $list->links() }}
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
    <script type="text/javascript">
        // 搜索
        function do_search() {
            var username = $("#username").val();
            var pay_id = $("#pay_id").val();
            var pay_no = $("#pay_no").val();

            window.location.href = '{{url('admin/qypayList')}}' + '?username=' + username + '&pay_id=' + pay_id + '&pay_no=' + pay_no;
        }

        // 重置
        function do_reset() {
            window.location.href = '{{url('admin/qypayList')}}';
        }
    </script>
@endsection