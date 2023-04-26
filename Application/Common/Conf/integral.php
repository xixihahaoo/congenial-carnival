<?php
//积分配置文件
return array(
    'FIRST_LOGIN'      	=> 20, 		//新用户首次登陆，并完成开户，获得20积分

    'FITST_RECHARGE'   	=> 20, 		//新用户首次入金，获得20积分

    'TRADE' 			=> 10, 		//每交易1手可自动获取10积分

    'ACC_TRADE' 		=> array(	//每月累计交易50次以上，次月可立刻获取50积分
    	'count' 		=> 50,
    	'intergral' 	=> 50
    ),

    'EVERY_LOGIN' 		=> 1, 		//每天登陆可以获得1积分

    'RECHARGE' 			=> array(	//入金可获取相应积分，入金积分=入金金额(美金) /20 当天最多获取1000积分
    	'intergral' 	=> 20,
    	'max_intergral' => 1000
    ),

    'EVERY_TRADE' 		=> array(	//交易累计超过2000手，5000订单，立刻获取5000积分
    	'every_number' 	=> 2000,
    	'count' 		=> 5000,
    	'intergral'		=> 5000
    ),
);