<?php 

include './Base.php';

class Alipay extends Base
{
	public function __construct($type)
	{
		if($type == 'md5'){
			return new md5Pay();
		}elseif($type == 'psa'){
			return new psaPay();
		}
	}

	public function md5Pay()
	{
		$params = [
			'service' => 'create_direct_pay_by_user', //接口名称 固定值
			'partner' => self::PID, //合作伙伴身份ID
			'_input_charset' => 'UTF-8', //商城网站编码格式
			'sing_type' => 'MD5', //签名方式
			'sign' => '',  //需要根据其他参数生成
			'notify_url' => self::NOURL, //异步通知地址 可空
			'return_url' => self::SEURL, //同步通知地址 可空
			'out_trade_no' => self::generate_order_sn(), //商城网站唯一订单号
			'subject' => '测试订单标题', //订单标题最长128汉字
			'payment_type' => 1, //支付类型 支取值为1(商品购买) 固定值
			// 'total_fee' => 0.01, //交易金额  单位 元
			'total_amount' => 0.01, //交易金额  单位 元
			'seller_id' => self::PID, //支付宝用户号 seller_id,seller_email,seller_account_name 至少传一个
			'body' => '测试订单描述', //商品描述 可空
		];

		echo '<pre>';

		$params = $this->getUrl($params);
		print_r(self::PAYGAWAY.'?'.$params);
	}
	public function psaPay()
	{
		$params = [
			'service' => 'create_direct_pay_by_user', //接口名称 固定值
			'partner' => self::PID, //合作伙伴身份ID
			'_input_charset' => 'UTF-8', //商城网站编码格式
			'sing_type' => 'PSA', //签名方式
			'sign' => '',  //需要根据其他参数生成
			'notify_url' => self::NOURL, //异步通知地址 可空
			'return_url' => self::SEURL, //同步通知地址 可空
			'out_trade_no' => self::generate_order_sn(), //商城网站唯一订单号
			'subject' => '测试订单标题', //订单标题最长128汉字
			'payment_type' => 1, //支付类型 支取值为1(商品购买) 固定值
			// 'total_fee' => 0.01, //交易金额  单位 元
			'total_amount' => 0.01, //交易金额  单位 元
			'seller_id' => self::PID, //支付宝用户号 seller_id,seller_email,seller_account_name 至少传一个
			'body' => '测试订单描述', //商品描述 可空
		];

		echo '<pre>';

		$params = $this->getUrl($params);
		print_r(self::PAYGAWAY.'?'.$params);
	}
	
}

	$obj = new Alipay('md5');