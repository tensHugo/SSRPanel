<?php

Route::any('login', 'LoginController@index'); // 登录
Route::get('logout', 'LoginController@logout'); // 退出
Route::any('register', 'RegisterController@index'); // 注册
Route::any('resetPassword', 'UserController@resetPassword'); // 重设密码
Route::any('reset/{token}', 'UserController@reset'); // 重设密码
Route::any('activeUser', 'UserController@activeUser'); // 激活账号
Route::get('active/{token}', 'UserController@active'); // 激活账号
Route::get('subscribe/{code}', 'SubscribeController@index'); // 节点订阅地址
Route::get('article', 'ArticleController@index'); // 定位文章详情
Route::post('locate', 'LocateController@locate'); // 上报文章打开时的定位
Route::get('free', 'UserController@free'); // 免费邀请码

Route::group(['middleware' => ['user', 'admin']], function() {
    Route::get('admin', 'AdminController@index'); // 后台首页
    Route::get('admin/userList', 'AdminController@userList'); // 账号列表
    Route::any('admin/addUser', 'AdminController@addUser'); // 添加账号
    Route::post('admin/batchAddUsers', 'AdminController@batchAddUsers'); // 批量生成账号
    Route::any('admin/editUser', 'AdminController@editUser'); // 编辑账号
    Route::post('admin/delUser', 'AdminController@delUser'); // 删除账号
    Route::get('admin/nodeList', 'AdminController@nodeList'); // 节点列表
    Route::any('admin/addNode', 'AdminController@addNode'); // 添加节点
    Route::any('admin/editNode', 'AdminController@editNode'); // 编辑节点
    Route::post('admin/delNode', 'AdminController@delNode'); // 删除节点
    Route::get('admin/nodeMonitor', 'AdminController@nodeMonitor'); // 节点流量监控
    Route::get('admin/articleList', 'AdminController@articleList'); // 文章列表
    Route::get('admin/articleLogList', 'AdminController@articleLogList'); // 文章访问日志列表
    Route::any('admin/addArticle', 'AdminController@addArticle'); // 添加文章
    Route::any('admin/editArticle', 'AdminController@editArticle'); // 编辑文章
    Route::post('admin/delArticle', 'AdminController@delArticle'); // 删除文章
    Route::get('admin/groupList', 'AdminController@groupList'); // 文章列表
    Route::any('admin/addGroup', 'AdminController@addGroup'); // 添加文章
    Route::any('admin/editGroup', 'AdminController@editGroup'); // 编辑文章
    Route::post('admin/delGroup', 'AdminController@delGroup'); // 删除文章
    Route::get('ticket/ticketList', 'TicketController@ticketList'); // 工单列表
    Route::any('ticket/replyTicket', 'TicketController@replyTicket'); // 回复工单
    Route::post('ticket/closeTicket', 'TicketController@closeTicket'); // 关闭工单
    Route::get('admin/inviteList', 'AdminController@inviteList'); // 邀请码列表
    Route::post('admin/makeInvite', 'AdminController@makeInvite'); // 生成邀请码
    Route::get('admin/exportInvite', 'AdminController@exportInvite'); // 导出邀请码
    Route::get('admin/applyList', 'AdminController@applyList'); // 提现申请管理
    Route::get('admin/applyDetail', 'AdminController@applyDetail'); // 提现申请管理
    Route::post('admin/setApplyStatus', 'AdminController@setApplyStatus'); // 设置提现申请状态
    Route::any('admin/config', 'AdminController@config'); // 配置列表
    Route::any('admin/addConfig', 'AdminController@addConfig'); // 添加配置
    Route::post('admin/delConfig', 'AdminController@delConfig'); // 删除配置
    Route::post('admin/addLevel', 'AdminController@addLevel'); // 增加等级
    Route::post('admin/updateLevel', 'AdminController@updateLevel'); // 更新等级
    Route::post('admin/delLevel', 'AdminController@delLevel'); // 删除等级
    Route::post('admin/addCountry', 'AdminController@addCountry'); // 增加国家/地区
    Route::post('admin/updateCountry', 'AdminController@updateCountry'); // 更新国家/地区
    Route::post('admin/delCountry', 'AdminController@delCountry'); // 删除国家/地区
    Route::post('admin/setDefaultConfig', 'AdminController@setDefaultConfig'); // 设置默认配置
    Route::get('admin/trafficLog', 'AdminController@trafficLog'); // 流量日志
    Route::get('admin/subscribeLog', 'AdminController@subscribeLog'); // 订阅请求日志
    Route::post('admin/setSubscribeStatus', 'AdminController@setSubscribeStatus'); // 启用禁用用户的订阅
    Route::any('admin/export', 'AdminController@export'); // 导出配置信息
    Route::any('admin/convert', 'AdminController@convert'); // 格式转换
    Route::any('admin/import', 'AdminController@import'); // 数据导入
    Route::get('admin/userMonitor', 'AdminController@userMonitor'); // 用户流量监控
    Route::any('admin/profile', 'AdminController@profile'); // 修改个人信息
    Route::get('admin/analysis', 'AdminController@analysis'); // 日志分析
    Route::get('admin/system', 'AdminController@system'); // 系统设置
    Route::post('admin/setConfig', 'AdminController@setConfig'); // 设置某个配置项
    Route::post('admin/setReferralPercent', 'AdminController@setReferralPercent'); // 设置返利比例
    Route::post('admin/setQrcode', 'AdminController@setQrcode'); // 设置充值二维码
    Route::post('admin/resetUserTraffic', 'AdminController@resetUserTraffic'); // 重置用户流量
    Route::post('admin/handleUserBalance', 'AdminController@handleUserBalance'); // 余额充值
    Route::get('admin/userOrderList', 'AdminController@userOrderList'); // 用户消费记录
    Route::get('admin/userBalanceLogList', 'AdminController@userBalanceLogList'); // 余额变动日志
    Route::get('admin/qypayList', 'AdminController@qypayList'); // 充值记录列表
    Route::get('admin/userBanLogList', 'AdminController@userBanLogList'); // 用户封禁记录
    Route::get('admin/makePasswd', 'AdminController@makePasswd'); // 获取随机密码
    Route::get('admin/download', 'AdminController@download'); // 下载转换过的JSON配置
    Route::any('shop/goodsList', 'ShopController@goodsList'); // 商品列表
    Route::any('shop/addGoods', 'ShopController@addGoods'); // 添加商品
    Route::any('shop/editGoods', 'ShopController@editGoods'); // 编辑商品
    Route::post('shop/delGoods', 'ShopController@delGoods'); // 删除商品
    Route::any('coupon/couponList', 'CouponController@couponList'); // 优惠券列表
    Route::any('coupon/addCoupon', 'CouponController@addCoupon'); // 添加优惠券
    Route::post('coupon/delCoupon', 'CouponController@delCoupon'); // 删除优惠券
    Route::get('coupon/exportCoupon', 'CouponController@exportCoupon'); // 导出优惠券
    Route::get('emailLog/logList', 'EmailLogController@logList'); // 邮件发送日志
    Route::post("admin/switchToUser","AdminController@switchToUser"); // 转换成某个用户的身份
    Route::any("admin/decompile", "AdminController@decompile"); // SS(R)链接反解析
});

Route::group(['middleware' => ['user']], function() {
    Route::any('/', 'UserController@index'); // 用户首页
    Route::any('user', 'UserController@index'); // 用户首页
    Route::any('user/article', 'UserController@article'); // 文章详情
    Route::get('user/subscribe', 'UserController@subscribe'); // 节点订阅
    Route::get('user/goodsList', 'UserController@goodsList'); // 商品列表
    Route::get('user/trafficLog', 'UserController@trafficLog'); // 流量日志
    Route::get('user/ticketList', 'UserController@ticketList'); // 工单
    Route::post('user/addTicket', 'UserController@addTicket'); // 快速添加工单
    Route::any('user/replyTicket', 'UserController@replyTicket'); // 回复工单
    Route::post('user/closeTicket', 'UserController@closeTicket'); // 关闭工单
    Route::get('user/orderList', 'UserController@orderList'); // 订单
    Route::any('user/addOrder', 'UserController@addOrder'); // 添加订单
    Route::post('user/redeemCoupon', 'UserController@redeemCoupon'); // 使用优惠券
    Route::get('user/invite', 'UserController@invite'); // 邀请码
    Route::post('user/makeInvite', 'UserController@makeInvite'); // 生成邀请码
    Route::any('user/profile', 'UserController@profile'); // 修改个人信息
    Route::post('user/exchange', 'UserController@exchange'); // 积分兑换流量
    Route::get('user/referral', 'UserController@referral'); // 推广返利
    Route::post('user/extractMoney', 'UserController@extractMoney'); // 申请提现
    Route::post("user/switchToAdmin","UserController@switchToAdmin"); // 转换成管理员的身份
    Route::post("user/charge","UserController@charge"); // 卡券余额充值
    Route::get("user/qypay", "UserController@qypay"); // 千应支付回调API
    Route::get("user/qyorderList", "UserController@qyorderList"); // 千应支付记录
    Route::post("user/qyOrderDel", "UserController@qyOrderDel"); // 作废充值订单
});

//Route::group(['middleware' => ['user']], function() {
    Route::any('payment/create', 'PaymentController@create'); // 创建支付
    Route::any('payment/execute', 'PaymentController@execute'); // 用户确认执行支付
    Route::any('payment/cancel', 'PaymentController@cancel'); // 用户取消支付
//});

Route::group(['middleware' => ['api']],function(){
	Route::get("api/get-token", "UserApi@get_token"); // 取token
	Route::get("api/login", "UserApi@get_token"); // 取token
    Route::post("api/login", "UserApi@login"); // API登录
    Route::get("api/subscribe", "UserApi@subscribe"); // 取订阅地址
    Route::post("api/get-userinfo", "UserApi@get_userinfo"); // 取用户信息
    Route::get("api/qypay_send", "UserController@qypay_send"); // 发起千应支付
    Route::get("api/qypay", "UserController@qypay"); // 千应支付回调API
});

