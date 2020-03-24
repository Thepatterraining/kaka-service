<?php
namespace Cybereits\Modules\ETH\API;

class EtherScanApi
{
    private $api_key ;
    private $token_key;
    public function __construct()
    {
        $this->api_key = config("eth.ethscankey");
        $this->token_key = config("eth.cre_contract");
    }
    public function QueryConfirm($txid)
    {
    }
    public function QueryEth($address)
    {
        $url = "https://api.etherscan.io/api?module=account&action=balance&address={$address}&tag=latest&apikey={$this->api_key}";
        $data = $this->_execReq($url);
        
        if ($data->status) {
            $value = $data -> result /1000000000000000000;
            return $value ;
        } else {
            return -1;
        }
    }
    public function QueryToken($address)
    {
        $add = $this->token_key;
        $url = "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress={$add}&address={$address}&tag=latest&apikey={$this->api_key}";

        $data = $this->_execReq($url);
        
        if ($data->status) {
            $value = $data -> result /1000000000000000000;
            return $value ;
        } else {
            return -1;
        }
    }

    /**
     * 查找一个地址的交易信息
     */
    public function QueryAddTrans($address, $from = 0)
    {
        $url = "http://api.etherscan.io/api?module=account&action=txlist&address={$address}&startblock={$from}&endblock=latest&sort=desc&apikey={$this->api_key}";
        $data = $this->_execReq($url);
        $items=[];
        if ($data->status) {
            foreach ($data->result as $raw) {
    $item = [
                    "txn"=>$raw -> hash,
                    "gasPrice"=>$raw->gasPrice/1000000000000000000,
                    "gasUsed"=>$raw->gasUsed,
                    "from"=>$raw->from,
                    "to"=>$raw->to,
                    "eth"=>$raw->value / 1000000000000000000,
                    "block"=>$raw->blockNumber,
                ];
                $items[]=$item;
            }
        }
        return $items;
    }



    public function QueryTxn($from, $to, $fromblk=0)
    {
        $add = $this->token_key;
        $topic1 = $this->_addtotopic($from);
        $topic2 = $this->_addtotopic($to);
        $url =  "https://api.etherscan.io/api?module=logs&action=getLogs&fromBlock=${fromblk}&toBlock=latest&address={$add}&topic1={$topic1}&topic2={$topic2}&apikey={$this->api_key}";
        $data = $this->_execReq($url);
                
        $items = [];
        if ($data->status) {
            foreach ($data->result as $raw) {
                $item = [
                            "txn"=>$raw -> transactionHash,
                            "gasPrice"=>$raw->gasPrice,
                            "gasUsed"=>$raw->gasUsed,
                            "from"=>$from,
                            "to"=>$to,
                            "tokentransfer"=>$this->_hextoval($raw->data),
                            "block"=>$raw->blockNumber,
                        ];
                $items[]=$item;
            }
        }
        return $items;
    }

    public function QueryTokenTxn($address,$fromblk=0)
    {
        $add = $this->token_key;
        $topic1 = $this->_addtotopic($address);
        $topic2 = $this->_addtotopic($address);
        $items = [];
        $url =  "https://api.etherscan.io/api?module=logs&action=getLogs&fromBlock=${fromblk}&toBlock=latest&address={$add}&topic2={$topic2}&apikey={$this->api_key}";
        $data = $this->_execReq($url);
                

        if ($data->status) {
            foreach ($data->result as $raw) {
              
                $item = [
                            "txn"=>$raw -> transactionHash,
                            "gasPrice"=>hexdec($raw->gasPrice)/1000000000000000000,
                            "gasUsed"=>hexdec($raw->gasUsed),
                            "from"=>$this->_topictoadd($raw->topics[1]),
                            "to"=>$this->_topictoadd($raw->topics[2]),
                            "tokentransfer"=>$this->_hextoval($raw->data),
                            "block"=>hexdec($raw->blockNumber),
                        ];
                $items[]=$item;
            }
        }
        $url =  "https://api.etherscan.io/api?module=logs&action=getLogs&fromBlock=${fromblk}&toBlock=latest&address={$add}&topic1={$topic1}&apikey={$this->api_key}";
        $data = $this->_execReq($url);
                        
        
        if ($data->status) {
            foreach ($data->result as $raw) {
                $item = [
                                    "txn"=>$raw -> transactionHash,
                                    "gasPrice"=>hexdec($raw->gasPrice)/1000000000000000000,
                                    "gasUsed"=>hexdec($raw->gasUsed),
                                    "from"=>$this->_topictoadd($raw->topics[1]),
                                    "to"=>$this->_topictoadd($raw->topics[2]),
                                    "tokentransfer"=>$this->_hextoval($raw->data),
                                    "block"=>hexdec($raw->blockNumber),
                                ];
                $items[]=$item;
            }
        }
        return $items;
    }




    public function QueryEthTxn($from, $to)
    {
    }

    private function _execReq($url)
    {
        $response =
        \Httpful\Request::get($url)
        ->send();
        $result =  $response->body;
        return $result ;
    }
    private function _addtotopic($add)
    {
        return "0x000000000000000000000000".substr($add, 2);
    }
    private function _topictoadd($topic)
    {
        return "0x".substr($topic, 26);
    }
        
    private function _hextoval($hex)
    {
        return hexdec($hex)/1000000000000000000;
    }
}
