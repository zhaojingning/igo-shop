<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     * 
     * 由于汇店地址是给支付宝的服务器调用的，肯定不会有 CSR TOKEN ，所以需要把这个URL驾到CSRF白名单里
     *
     * @var array<int, string>
     */
    protected $except = [
        'payment/alipay/notify',
        'payment/wechat/notify',
        'payment/wechat/refund_notify'
    ];
}
