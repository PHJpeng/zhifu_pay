<?php
include './Base';

class Notify extends Base
{
	public function __construct()
	{
		//1 接收参数
		$data = $_POST;

		//2 验证签名
		if($data['sign_type'] == 'MD5'){
			if(!$this->checkSign($data)){
				$this->logs('log.txt','MD5签名验证失败!')
				exit();
			}else{
				$this->logs('log.txt','MD5签名验证成功!')
			}
		}elseif($data['sign_type'] == 'RSA'){
			if(!$this->rsaCheck($this->getStr($data), self::PUBLICKEY, $data['sign'],$sign_type='OPENSSL_ALGO_SHA1')){
				$this->logs('log.txt','RSA签名验证失败!')
				exit();
			}else{
				$this->logs('log.txt','RSA签名验证成功!')
			}
		}
		

		//3 验证是否来自支付宝的url
		if($this->isAliay($data)){
			$this->logs('log.txt','URL验证失败!')
			exit();
		}else{
			$this->logs('log.txt','URL验证成功!')
		}
		//4验证支付状态
		if(!$this->checkOrderStatus($data)){
			$this->logs('log.txt','支付状态验证失败!')
			exit();
		}else{
            $this->logs('log.txt','支付状态验证成功!')
		}

		//5验证订单号和金额
		$this->logs('log.txt','订单号'.$data['out_trae_no'].'订单金额'.$data['total_fee']);// 在实际的交易环境中需要和订单表中的金额做对比

		//6修改订单状态  操作数据库修改订单状态
		echo 'success'; // 一定要给支付宝返回success成功 否则支付宝会不间断的在次返回数据

	}

}