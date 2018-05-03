
<?php	
header("Content-type:text/html;charset=utf-8");
$data=$_GET;       //post方式获得表单提交的数据


$user_id = $data['user_id'];                    
$shop_id=3473;         //商户ID，商户在千应官网申请到的商户ID
$bank_Type=$data['bank_type'];   //充值渠道，101表示支付宝快速到账通道
$bank_payMoney=$data['totalAmount'];     //充值金额
$orderid='ftz'.time().time();                  //商户的订单ID，【请根据实际情况修改】
$callbackurl="http://user.fiypig.org/api/qypay";        //商户的回掉地址，【请根据实际情况修改】
$gofalse="https:/user.fiypig.org/";                    //订单二维码失效，需要重新创建订单时，跳到该页
$gotrue="https:/user.fiypig.org/";                         //支付成功后，跳到此页面
$key="4aa390add3f240f08b740c08f9345a61";                      //密钥
$posturl='http://www.qianyingnet.com/pay/';                   //千应api的post提交接口服务器地址

$charset="utf-8";                                              //字符集编码方式
$token=$user_id;                                                //自定义传过来的值 千应平台会返回原值
$parma='uid='.$shop_id.'&type='.$bank_Type.'&m='.$bank_payMoney.'&orderid='.$orderid.'&callbackurl='.$callbackurl;     //拼接$param字符串
$parma_key=md5($parma . $key);                                 //md5加密
$PostUrl=$posturl."?".$parma."&sign=".$parma_key."&gofalse=".$gofalse."&gotrue=".$gotrue."&charset=".$charset."&token=".$token;       //生成指定网址


//跳转到指定网站
if (isset($PostUrl)) 
   { 
       header("Location: $PostUrl"); 
       exit;
   }else{
			 	echo "<script type='text/javascript'>";
				echo "window.location.href='$PostUrl'";
				echo "</script>";	
};
?>
