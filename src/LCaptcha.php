<?php

namespace Lshorz\Luocaptcha;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Config;

class LCaptcha
{
    /**
     * @var string
     */
    protected $service_url;

    /**
     * @var string
     */
    protected $api_key;

    protected $error_code = null;

    public function __construct()
    {
        $this->service_url = Config::get('lcaptcha.services_url');
        $this->api_key = Config::get('lcaptcha.api_key');
    }

    /**
     * 服务端验证
     *
     * @param string $response
     *
     * @return bool
     */
    public function verify($response)
    {
        $res = $this->request($response);
        if (isset($res->res) && $res->res == 'success') {
            return true;
        } else {
            $this->error_code = $res->error;
            return false;
        }
    }

    /**
     * 生成验证验证html组件
     *
     * @param string $width 验证组件宽度:400|100%
     * @param string $callback 验证成功回调函数名
     * @return string
     */
    public function render($width = '100%', $callback = 'getResponse')
    {
        $html = '<script src="//captcha.luosimao.com/static/js/api.js"></script>';
        $html .= '<div class="l-captcha" data-width="' . $width . '" data-site-key="' . config('lcaptcha.site_key') . '" data-callback="' . $callback . '"></div>';
        return $html;
    }

    /**
     * 返回错误描述
     */
    public function getError()
    {
        if (isset($this->error_code)) {
            switch ($this->error_code) {
                case -10:
                    return Config::get('lcaptcha.message.api_key_empty');
                    break;
                case -11:
                    return Config::get('lcaptcha.message.response_empty');
                    break;
                case -40:
                    return Config::get('lcaptcha.message.api_key_error');
                    break;
                default:
                    return Config::get('lcaptcha.message.response_error');
                    break;
            }
        } else {
            return null;
        }
    }

    /**
     * 返回错误代码
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * @param string $responseString
     *
     * @return bool|mixed
     */
    private function request($responseString)
    {
        $client = new Client();
        try {
            $result = $client->post($this->service_url, [
                'verify' => false,
                'form_params' => [
                    'api_key' => $this->api_key,
                    'response' => $responseString
                ]
            ]);
            return json_decode($result->getBody());
        } catch (ClientException $e) {
            return false;
        }
    }
}