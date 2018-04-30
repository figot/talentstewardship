<?php

namespace daixianceng\smser;

use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * 中国云信
 * 
 * @author Cosmo <daixianceng@gmail.com>
 * @property string $password write-only password
 * @property string $state read-only state
 * @property string $message read-only message
 */
class CloudSmser extends Smser
{
    /**
     * @inheritdoc
     */
    public $url = 'http://api.sms.cn/sms/';
    
    /**
     * @inheritdoc
     */
    public function send($mobile, $content)
    {
        if (parent::send($mobile, $content)) {
            return true;
        }
        
        $data = [
            'ac' => 'send',
            'uid' => $this->username,
            'pwd' => "d1910d8281cee93c26fc159b69d35ecb",
            'mobile' => $mobile,
            'content' => $content,
            'template' => 422143,
        ];
        
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $this->url);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//
//        $result = curl_exec($ch);
//        \Yii::info("xxxxxxxxx" . var_export($ch, true));
//        \Yii::info("xxxxxxxxx" . var_export($result, true));
//        curl_close($ch);
        $result = $this->curlRequest($this->url, $data);
        
        $resultArr = json_decode($result, true);
        //\Yii::info("xxxxxxxxx" . var_export($resultArr, true));
        //parse_str($result, $resultArr);
        
        //$this->state = isset($resultArr['stat']) ? (string) $resultArr['stat'] : null;
        //$this->message = isset($resultArr['message']) ? (string) $resultArr['message'] : null;
        if (strpos($result, '100') !== false) {
            return true;
        }

        //return $this->state === '100';
    }
    /**
     * 通过CURL发送HTTP请求
     * @param string $url	//请求URL
     * @param array $postFields //请求参数
     * @return string
     */
    public function curlRequest($url,$postFields){
        $postFields = http_build_query($postFields);
        \Yii::info("xxxxxxxxx" . var_export($postFields, true));
        //echo $url.'?'.$postFields;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_HEADER, 0 );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields );
        $result = curl_exec($ch);
        \Yii::info("xxxxxxxxx" . var_export($result, true));
        curl_close($ch);
        return $result;
    }
    
    /**
     * 设置密码
     * 
     * @param string $password
     * @throws InvalidConfigException
     */
    public function setPassword($password)
    {
        if ($this->username === null) {
            throw new InvalidConfigException('用户名不能为空');
        }
        
        $this->password = md5($password . $this->username);
    }
    
    /**
     * @inheritdoc
     */
    public function sendByTemplate($mobile, $data, $id)
    {
        throw new NotSupportedException('中国云信不支持发送模板短信！');
    }
}