<?php
return [
    'services_url' => 'https://captcha.luosimao.com/api/site_verify', //服务端验证地址（不用修改）
    'response_field' => 'luotest_response', //不用修改
    'site_key' => 'your site_key',
    'api_key' => 'your api_key',
    'message' => [
        'api_key_empty' => 'api_key 为空',
        'api_key_error' => 'api_key 错误',
        'response_empty' => 'response 为空',
        'response_error' => 'response 错误',
        'server_fail' => '服务端验证失败'
    ],
];