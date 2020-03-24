
-- 增加协议类型
alter table `transaction_contract` add `contract_leveltype` char(10) NOT NULL DEFAULT 'CL01' COMMENT '协议类型 CL00 普通 CL01 一级产品';

-- 更新之前的协议为一级产品
update `transaction_contract` set `contract_leveltype` = 'CL01';