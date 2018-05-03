<?php

namespace App\Http\Controllers;

use App\Http\Models\Article;
use App\Http\Models\Coupon;
use App\Http\Models\CouponLog;
use App\Http\Models\Goods;
use App\Http\Models\Invite;
use App\Http\Models\Level;
use App\Http\Models\Order;
use App\Http\Models\ReferralApply;
use App\Http\Models\ReferralLog;
use App\Http\Models\SsConfig;
use App\Http\Models\Ticket;
use App\Http\Models\TicketReply;
use App\Http\Models\User;
use Illuminate\Http\Request;
use App\Http\Models\UserSubscribe;
use Response;


class UserApi extends Controller
{
   protected static $config;
    protected static $userLevel;

    function __construct()
    {
        self::$config = $this->systemConfig();
    }
   public function resbang(Request $request){
      $msg = array(
          'code' => 0,
          'msg' => 'ćĺ'
      );
     return json_encode($msg);
   }
   
   public function get_token(){
   	$token = csrf_token();
	if($token!=""){
		return Response::json(array('code' => 1,'msg' => '获取成功','token' => $token));
	}else{
		return Response::json(['code' => 0,'msg' => '获取失败','token' => $token]);
	}
    
   	
   }
  
  /*
   * API登录  参数如下：
   * _token:回话ID
   * user:用户名
   * password:密码
   */
  public function login(Request $request){
  	$username = $request->get('user');
	$password = $request->get('password');
	$user = User::query()->where('username', $username)->where('password', md5($password))->first();
            if (!$user) {
            	
                return Response::json(array('code' => 1001,'msg' => '用户名密码错误'));
            } else if ($user->status < 0) {
                return Response::json(array('code' => 1002,'msg' => '账号被禁用'));
            } else if ($user->status == 0 && self::$config['is_active_register'] && $user->is_admin == 0) {
                
                return Response::json(array('code' => 1003,'msg' => '账号未激活，请先登录用户中心激活账号'));
            }
            // 更新登录信息
            $remember_token = "";
            User::query()->where('id', $user->id)->update(['last_login' => time()]);
            if ($request->get('remember')) {
                $remember_token = $this->makeRandStr(20);

                User::query()->where('id', $user->id)->update(['last_login' => time(), "remember_token" => $remember_token]);
            } else {
                User::query()->where('id', $user->id)->update(['last_login' => time()]);
            }
	            // 重新取出用户信息
            $userInfo = User::query()->where('id', $user->id)->first();
            $request->session()->put('user', $userInfo->toArray());
	
	return Response::json(array('code' => 1,'msg' => '登录成功','info'=> [
	    'user'=>$userInfo['username'],
	    'enable'=>$userInfo['enable']
	    ]));
  }
  
  /*
   * 取订阅地址  参数如下：
   * _token：会话ID
   * user：用户名
   */
    public function subscribe(Request $request)
    {
    		    	
        $user = $request->session()->get('user');
		
		if($request->get('user')!=$user['username']){
			return Response::json(array('code' => 1005,'msg' => '当然登录状态不合法'));
		}
		
		if(!$user){
			return Response::json(array('code' => 0,'msg' => '获取失败，您还未登录'));
		}

        // 如果没有唯一码则生成一个
        $subscribe = UserSubscribe::query()->where('user_id', $user['id'])->first();
        if (empty($subscribe)) {
            $code = mb_substr(md5($user['id'] . '-' . $user['username']), 8, 12);

            $obj = new UserSubscribe();
            $obj->user_id = $user['id'];
            $obj->code = $code;
            $obj->times = 0;
            $obj->save();
        } else {
            $code = $subscribe->code;
        }

        $like = self::$config['website_url'] . '/subscribe/' . $code;

        return Response::json(array('code' => 1,'msg' => '获取成功','like'=>$like));
    }
	
	/*
	 * 取用户信息 get方法 参数如下：
	 * _token:会话ID
	 * user:用户名
	 */
	public function get_userinfo(Request $request){
		$user = $request->session()->get('user');
		if(!$user){
			return Response::json(array('code' => 0,'msg' => '获取失败，您还未登录'));
		}
		if(strcmp($request->get('user'),$user['username'])!=0){
			return Response::json(array('code' => 1005,'msg' => '当然登录状态不合法'.$request->get('user')));
		}
		
		$userInfo = User::query()->where('username', $request->get('user'))->first();
		$info = $userInfo->toArray();
		unset($info['password']);
		
		return Response::json(array('code' => 1,'msg' => '获取成功','info'=>$info));
	}
  
}
