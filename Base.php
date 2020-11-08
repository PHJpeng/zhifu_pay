<?php
include './RSA.php';
class Base extends RSA
{
	const PID = '2088521397903003';
	const NOURL = 'http://www.peng.com/alipay/notify.php';//异步通知回调地址url
	const SEURL = 'http://www.peng.com/alipay/return.php';//同步通知回调地址url
	const KEY = '5a9tjo2amff8i9nflilk0uecyhodkqtk';//同步通知回调地址url
	// const PAYGAWAY = 'https://mapi.alipay.com/gateway.do';//发送请求支付接口地址url
	const PAYGAWAY = 'https://openapi.alipay.com/gateway.do';//发送请求支付接口地址url
	const HECKURL = 'https://openapi.alipay.com/gateway.do';//发送请求支付接口地址url
	const APPPRIKEY = 'https://openapi.alipay.com/gateway.do';//支付宝私钥
	const PUBLICKEY = 'https://openapi.alipay.com/gateway.do';//支付宝公钥


	//处理字符串
	public function getStr($arr)
	{
		// 删除 筛选过滤sing sing_type
		if(isset($arr['sign'])){
			unset($arr['sign']);
		}
		if(isset($arr['sign_type'])){
			unset($arr['sign_type']);
		}
		//进行ascma排序
		ksort($arr);
		//拼接url  返回一个字符串
		return $this->getUrl($arr,false); //乱码问题
		
	}

	//将数组转为url格式的字符串
	public function getUrl($arr,$encode = true)
	{
		if($encode){
			return http_build_query($arr,true);
		}else{
			return urldecode(http_build_query($arr));//经过urldecode()进行url编码解码	
		}	
	}

	//生成 MD5 sign签名  根据字符串后面拼接上key 在MD5加密 返回
	public function getSign($arr)
	{
		return md5($this->getStr($arr).self::KEY);
	}

	//获取含有签名的数组 MD5类型
	public function setSign($arr)
	{
		$arr['sign'] = $this->getSign($arr);
		return $arr;
	}

	//获取RSA类型签名
	public function getRsaSign($arr)
	{
		$this->rsaSign($this->getStr($arr).self::APPPRIKEY);//第一个参数是字符串 第二个参数是 支付宝的私钥
	}

	//获取含有签名的数组 RSA类型
	public function setRsaSign($arr)
	{
		$arr['sign'] = $this->getRsaSign($arr);
		return $arr;
	}

	//验证签名方法
	public function checkSign($arr)
	{
		$sign = $this->getSign($arr);
		if($sign == $arr['sign']){
			return true;//如果相等  返回true
		}else{
			return false;//否则返回false
		}
	}

	//生成日志文件
	public function logs($filename, $data)
	{
		file_get_contents('./logs/'.$filename,$data.'\r\n'.FILE_APPEND);
	}

	//验证是否来自支付宝的通知
	public function isAliay($arr)
	{
		$str = file_get_contents(self::HECKURL.$arr['notify_id']);
		if($str == 'true'){
			return true;
		}else{
			return false;
		}
	}

	//验证交易状态
	public function checkOrderStatus($arr)
	{
	if($arr['trade_status'] == 'TRADE_SUCCESS' || $arr['trade_status'] == 'TRADE_FINISHED')
		return true;
	}else{
		return false;
	}

	//成订单号
	public function generate_order_sn($id = '')
	{
	    return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8)  . $id;
	}
}