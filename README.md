# Luosimao 人机验证 Laravel 5.X 扩展

基于[Luosimao](https://luosimao.com/)免费人机验证的Laravel 5.x扩展

![介绍](https://s.luosimao.com/images/website/captcha/screenshot.jpg)

## 安装

```php
$ composer require "lshorz/luocaptcha":"dev-master"
```

如果是laravel<5.5 则修改config/app.php
增加
```php
Lshorz\Luosimao\LCaptchaServiceProvider::class
```
增加aliases
```php
'LCaptcha' => Lshorz\Luosimao\Facades\LCaptcha::class,
```

## 配置
1.执行
```php
$ php artisan vendor:publish --tag=lcaptcha
```
2.去官注册帐号并配置config/lcaptcha.php

## 使用方法
在需要显示该验证组件的插入
```php
/**
* @param string $width  组件宽度
* @param string $callback 客户端验证成功回调函数名称
*/
{!! LCaptcha::render('100%', 'callback') !!}
```
将会生成类似代html代码
```html
<script src="//captcha.luosimao.com/static/js/api.js"></script>
<div class="l-captcha" data-width="200" data-site-key="xxxxxxxxxxxxxx" data-callback="callback"></div>
```
另外需要自己补充JS方法，例如将取得的response(默认参数名为：*luotest_response*)参数post到服务器进行远程验证,参考如下：
```html
<script>
    function callback(resp){
        $.post('/check', {"luotest_response": resp}, function(res){
            console.log(res);
        });
    }
</script>
```

### 服务端验证
方法一：
```php
$v = Validator::make($request->only('luotest_response'), ['luotest_response'=>'required|lcaptcha'], 
 [
    'luotest_response.required' => '不得为空',
    'luotest_response.lcaptcha'=>'验证失败'
 ]);
if ($v->fails()) {
    return $v->errors();
} else {
    return 'ok';
}
```

方法二：
```php
use Lshorz\Luocaptcha\Facades\LCaptcha;

...

$res = LCaptcha::verify($request->only('luotest_response'));
if ($res) {
    echo 'passed';
} else {
    echo 'fail';
}
```

其他请参考：
# [luosimao官方使用文档](https://luosimao.com/docs/api/56)









