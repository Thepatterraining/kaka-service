# 说明
1. 本分支为拆分服务队列的功能分支
2. 上线时间  待议
# 迁移到百度云说明
## 增加验证码 更新 2017.5.1 // Happy May Day
Test to Release
测试发布
安装php的gd扩展

	apt install php5.6-gd


## 更新原来的service
	
 	mv kksevice kkservice-back   
	git clone https://xiaolvyun.baidu.com/git/kkmf/pulic/service kkservice  
	mv kkservice-back/.env kkservice/   
	cd kkservice    
	composer install    
	chmod 777 storage/* -R   

## 更改配置文件
	
	vim config/rabbitmq.php

将 `    "enable"=>true, ` 改为  `    "enable"=>false, `

## 更新SQL
	
	cd sqlquery
	cat v3_* > v3_update.sql

## 执行SQL

## Test The Request Pull
