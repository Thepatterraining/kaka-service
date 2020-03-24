#!/bin/bash
echo 还原何旭东现金流水
php artisan kk:userCash  234 0 0 20000.02 " -20000.02"
php artisan kk:userCash  234 0 51.67 0 "51.67"
echo 还原刘宁现金流水
php artisan kk:userCash 7 0 18948.69 0 " -18948.69"  
echo 还原何旭东代币流水 
php artisan kk:userCoin 234 0 0 KKC-BJ0001 --pending=-0.08
php artisan kk:userCoin 234 0  0 KKC-BJ0002 --pending=-0.04
echo 还原刘宁代币流水
php artisan kk:userCoin 7  0.04  0  KKC-BJ0002 --pending=0
php artisan kk:userCoin 7  0.08   0  KKC-BJ0001 --pending=0
echo 还原系统现金流水 
php artisan kk:flatCash 0 51.31 0 152501671
php artisan kk:flatCash 130 0 0 152501671

