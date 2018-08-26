<?php

namespace fatjiong\express;

/**
 * This is just an example.
 */
class Express extends \yii\base\Component
{
    public $url;
    public $comUrl;
    public $topicUrl;
    public $key;
    public $topicBackUrl;
    private $data;
    public $customer;

    public function init()
    {
        parent::init();

        // 快递查询连接
        if (!$this->url) {
            $this->url = 'http://www.kuaidi100.com/query';
        }

        if (!$this->topicUrl) {
            $this->topicUrl = YII_ENV == 'dev' ? 'https://poll.kuaidi100.com/test/poll' : 'https://poll.kuaidi100.com/poll';
        }

        // 快递名称查询连接
        if (!$this->comUrl) {
            $this->comUrl = 'http://www.kuaidi100.com/autonumber/auto';
        }

        if (!$this->data) {
            $this->data = [
                'shunfeng'               => '顺丰',
                'yuantong'               => '圆通速递',
                'shentong'               => '申通',
                'yunda'                  => '韵达快运',
                'ems'                    => 'ems快递',
                'tiantian'               => '天天快递',
                'zhaijisong'             => '宅急送',
                'quanfengkuaidi'         => '全峰快递',
                'zhongtong'              => '中通速递',
                'rufengda'               => '如风达',
                'debangwuliu'            => '德邦物流',
                'huitongkuaidi'          => '汇通快运',
                'aae'                    => 'aae全球专递',
                'anjie'                  => '安捷快递',
                'anxindakuaixi'          => '安信达快递',
                'biaojikuaidi'           => '彪记快递',
                'bht'                    => 'bht',
                'baifudongfang'          => '百福东方国际物流',
                'coe'                    => '中国东方（COE）',
                'changyuwuliu'           => '长宇物流',
                'datianwuliu'            => '大田物流',
                'dhl'                    => 'dhl',
                'dpex'                   => 'dpex',
                'dsukuaidi'              => 'd速快递',
                'disifang'               => '递四方',
                'fedex'                  => 'fedex（国外）',
                'feikangda'              => '飞康达物流',
                'fenghuangkuaidi'        => '凤凰快递',
                'feikuaida'              => '飞快达',
                'guotongkuaidi'          => '国通快递',
                'ganzhongnengda'         => '港中能达物流',
                'guangdongyouzhengwuliu' => '广东邮政物流',
                'gongsuda'               => '共速达',
                'hengluwuliu'            => '恒路物流',
                'huaxialongwuliu'        => '华夏龙物流',
                'haihongwangsong'        => '海红',
                'haiwaihuanqiu'          => '海外环球',
                'jiayiwuliu'             => '佳怡物流',
                'jinguangsudikuaijian'   => '京广速递',
                'jixianda'               => '急先达',
                'jjwl'                   => '佳吉物流',
                'jymwl'                  => '加运美物流',
                'jindawuliu'             => '金大物流',
                'jialidatong'            => '嘉里大通',
                'jykd'                   => '晋越快递',
                'kuaijiesudi'            => '快捷速递',
                'lianb'                  => '联邦快递（国内）',
                'lianhaowuliu'           => '联昊通物流',
                'longbanwuliu'           => '龙邦物流',
                'lijisong'               => '立即送',
                'lejiedi'                => '乐捷递',
                'minghangkuaidi'         => '民航快递',
                'meiguokuaidi'           => '美国快递',
                'menduimen'              => '门对门',
                'ocs'                    => 'OCS',
                'peisihuoyunkuaidi'      => '配思货运',
                'quanchenkuaidi'         => '全晨快递',
                'quanjitong'             => '全际通物流',
                'quanritongkuaidi'       => '全日通快递',
                'quanyikuaidi'           => '全一快递',
                'santaisudi'             => '三态速递',
                'shenghuiwuliu'          => '盛辉物流',
                'sue'                    => '速尔物流',
                'shengfeng'              => '盛丰物流',
                'saiaodi'                => '赛澳递',
                'tiandihuayu'            => '天地华宇',
                'tnt'                    => 'tnt',
                'ups'                    => 'ups',
                'wanjiawuliu'            => '万家物流',
                'wenjiesudi'             => '文捷航空速递',
                'wuyuan'                 => '伍圆',
                'wxwl'                   => '万象物流',
                'xinbangwuliu'           => '新邦物流',
                'xinfengwuliu'           => '信丰物流',
                'yafengsudi'             => '亚风速递',
                'yibangwuliu'            => '一邦速递',
                'youshuwuliu'            => '优速物流',
                'youzhengguonei'         => '邮政包裹挂号信',
                'youzhengguoji'          => '邮政国际包裹挂号信',
                'yuanchengwuliu'         => '远成物流',
                'yuanweifeng'            => '源伟丰快递',
                'yuanzhijiecheng'        => '元智捷诚快递',
                'yuntongkuaidi'          => '运通快递',
                'yuefengwuliu'           => '越丰物流',
                'yad'                    => '源安达',
                'yinjiesudi'             => '银捷速递',
                'zhongtiekuaiyun'        => '中铁快运',
                'zhongyouwuliu'          => '中邮物流',
                'zhongxinda'             => '忠信达',
                'zhimakaimen'            => '芝麻开门',
            ];
        }
    }

    /**
     * [search 免费查询快递]
     * @author 胖纸囧
     * @datetime        2018-06-20T19:42:07+0800
     * @return   [type] [description]
     */
    public function search(string $number, string $code = '', $output = 'json')
    {
        if (!empty($number) && empty($code)) {
            $code = $this->getCom($number, 'code');
        }
        if (!empty($number) && !empty($code)) {
            $data = array(
                'type'   => trim($code),
                'postid' => trim($number),
            );

            //请求接口
            $result = $this->call('get', $this->url, $data);
            if (empty($result)) {
                $result = json_encode(array('status' => 400, 'message' => '请求错误'));
            }
        } else {
            $result = json_encode(array('status' => 400, 'message' => '快递单号不正确'));
        }
        return $output == 'json' ? $result : json_decode($result);
    }

    /**
     * [searchPay 付费查询快递]
     * @author 胖纸囧
     * @datetime        2018-08-21T11:32:13+0800
     * @param    string $number                  [description]
     * @param    string $code                    [description]
     * @param    string $output                  [description]
     * @return   [type]                          [description]
     */
    public function searchPay(string $number, string $code = '', $output = 'json')
    {
        if (!$this->key) {
            $result = json_encode(array('status' => 400, 'message' => '请配置key'));
        }

        if (!$this->customer) {
            $result = json_encode(array('status' => 400, 'message' => '请配置customer'));
        }

        if (!$code) {
            $code = $this->getCom($number, 'code');
        }

        $url = 'http://poll.kuaidi100.com/poll/query.do';

        $data['customer'] = $this->customer;
        $data["param"]    = '{"com":"' . $code . '", "num":"' . $number . '"}';
        $data['sign']     = md5($data["param"] . $this->key . $data["customer"]);
        $data["sign"]     = strtoupper($data["sign"]);

        //请求接口
        $result = $this->call('post', $url, $data);

        if (empty($result)) {
            $result = json_encode(array('status' => 400, 'message' => '请求错误'));
        }
        return $output == 'json' ? $result : json_decode($result);
    }

    /**
     * [topic 物流订阅]
     * @author 胖纸囧
     * @datetime        2018-06-26T10:37:49+0800
     * @param    string $number                  [运单编号]
     * @return   [type]                          [description]
     */
    public function topic(string $number, string $code = '', string $schema = 'json')
    {
        if (!$this->key) {
            $result = json_encode(array('status' => 400, 'message' => '请配置key'));
        }

        if (!$this->topicBackUrl) {
            $result = json_encode(array('status' => 400, 'message' => '请配置回调地址'));
        }

        if (!$code) {
            $code = $this->getCom($number, 'code');
        }
        $data['schema'] = $schema;
        $data["param"]  = '{"company":"' . $code . '", "number":"' . $number . '",';
        $data["param"] .= '"key":"' . $this->key . '",';
        $data["param"] .= '"parameters":{"callbackurl":"' . $this->topicBackUrl . '"}}';

        //请求接口
        $result = $this->call('post', $this->topicUrl, $data);

        if (empty($result)) {
            $result = json_encode(array('status' => 400, 'message' => '请求错误'));
        }
        return $schema == 'json' ? $result : json_decode($result);

    }

    /**
     * [getCom 获取快递的名称]
     * @author 胖纸囧
     * @datetime        2018-06-20T19:47:10+0800
     * @param    string $number                  [description]
     * @param    string $type                    [description]
     * @return   [type]                          [description]
     */
    public function getCom(string $number, $output = 'name')
    {
        $code   = '';
        $result = $this->call('get', $this->comUrl, ['num' => $number]);
        if (!empty($result)) {
            $name = @json_decode($result, true);
            $code = isset($name[0]['comCode']) ? $name[0]['comCode'] : '';
        }
        return $output == 'name' ? (isset($this->data[$code]) ? $this->data[$code] : $code) : $code;
    }

    /**
     * [call 模拟Http请求方法]
     * @Author 胖纸囧
     * @Date   2017-07-26T20:40:38+0800
     * @param  string                   $type   [推送类型:post/get]
     * @param  string                   $url    [请求url]
     * @param  array                    $params [请求参数]
     * @param  array                    $header [设置header]
     * @param  boolean                  $isSign [是否签名]
     * @return [type]                           [description]
     */
    public function call(string $type = 'POST', string $url, array $params = [], array $header = [])
    {
        // 设置超时时间10S
        set_time_limit(10);

        // new 一个http客户端
        $client = new \yii\httpclient\Client();
        // http客户端发起请求
        $request = $client->createRequest();

        // 设置请求方法
        !in_array(strtolower($type), ['post', 'get']) && $type = 'post';
        $request->setMethod($type);

        // 设置请求链接
        $request->setUrl($url);

        // 设置请求头
        !empty($header) && $request->addHeaders($header);

        // 设置请求参数
        !empty($params) && $request->setData($params);

        // 发起请求
        $response = $request->send();

        // 返回值
        return $response->getContent();
    }
}
