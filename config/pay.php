<?php

declare(strict_types=1);

use Yansongda\Pay\Pay;

$appPrivateKey = file_get_contents(config_path('alipay/appPrivateKey'));
$str            =  chunk_split(base64_encode($appPrivateKey), 64, "\n");
$appPrivateKey = "-----BEGIN RSA PRIVATE KEY-----\n$str-----END RSA PRIVATE KEY-----\n";

$appPrivateKey = 'MIIEogIBAAKCAQEAoWvLG2FT9l/lXrQ411mo10oheFAnR9ze6DRJNSf60VR2SH66gbWYTyIryAdRsiCF2TWbva4c7pjeeukMLpVydBVPzmnMV5/oMJ4Gzk0NU/rfcRStQ/FvMVdADhRESYv8aQXWq7YUVYr4UAVGc7+ggL1e9keUinnV2g8ds6tUoMSwSumJVjKNIuRGRN8UpPg4wTiH/IGBp+Vvp381leo1eiazAa9lw+SrQ5Phx92vYu18kWwYjr3o6ZAMvhQdv/gM2hsd7Ge/t34y6gBFLzScMTy1mz4YmsBtzpaMcMI4DN8ZNwLxHgASH8CiOVq5sixeCDkaa/CVlqFn6cljSkOUqQIDAQABAoIBADcFqjbMBzWs3F9aqSFms3GnGB+NmsYZGHYoFGglF46w7pypbeN2xdL7f9bv/73q7hTq/Ao8xiniO7vDol5inJ/K/+gJEhkwLZIc248Inqloky9Vb/X/3vn/lpr194zmRYR69ACV0PqToy6Ljcc4o3oekrb6ETzeaLGqg2JR3UfrGNqxbpjXE2K4gVCQBKGteZcA2sjMj9916H/EE98j6whITPKZ/KUeRB6NZuRrijzG+CNFk7uJBOFli/67/l9ixcGfgJYBaRLWw514jWllZ8qU1bRe3LOMq0YOOkbamIZSenQNHpt5UDV2YKWNQQkPa3LIoz6fEi5DRANjPlyjZAECgYEAz7YA2y1hscAY0w52otfkms0Xrbyxxp3IRjyW5YN4J7slju1xopKtwJ5veMqbraB3RNkcY3hHBx0i1+p4Lo1tGS9umwkM5LCc66ICdVuF0QpX7AzeUhqnwBNNTuxPVDopuPGSM9m8b/rTQaJd7uLnrM9xYK8H5L2FDKw/Lt6rrSkCgYEAxvLUeTBwutHOjiRpjc0Bs8pdIibh6Nr+amjlOQkP96wafMGGe8Ay/p8er8RVCLZKBKzjpECGTVgDZMtEO0BrPbE8w7uxUZY+YkoKdAvNrO7Bq9mczzGR2zrlfZaLlNfdiKBj3MkkKDEdHhP6/H7iXI37jsuP+LJzqlEcN3hOG4ECgYA7eFTObDPofKOe6ik1frLJT6dT6w7LWymYUoixte6VEZQzU/CRJ4Xv/GzWHMxt7d+4KqFiKXHMq57qSwuV6JAwAdCdOv4iDB8hqAUkLMwnidqajySoRVF6QQyFaEteRjjj5uaBSfoV5a7Ov/o9B2JlrA8+K18LMugBNN/yP3bP4QKBgDeg7KJaVhsW0U/ThKQ+v4wbOIF1J9PpcBwm6nlRPGK/f8SEhGsT6e5iZb02A6Tk+7tk8F4cILF9u60yXQjIUXQ1m80LLWCnxxfKpjOenUsOk57OwVb6AFOxmzvLnYnn9ize1C2HHJIUcZTYd2SkwfypQr7B0qbylv73oREtlYGBAoGAfVluo9mHIuPz7rHI/eGQVS3wBQlKv/AXbK0SOuObwp3SE9pNbeYlBQKaYtbjsmw/LEoP58mE/Y6lcSURFyyXxZMUvK6X4Sx55xZyGos+zkmBjuwuJa0M0o+AtoIfZRxEFPKLryc0Rc+fmlX/Q3zluFGrVKaf+VlEKgvxib41nhE=';

return [
    'alipay' => [
        'default' => [
            // 必填-支付宝分配的 app_id
            'app_id' => '2021000122671497',
            // 必填-应用私钥 字符串或路径
            'app_secret_cert' => $appPrivateKey,
            // 必填-应用公钥证书 路径
            'app_public_cert_path' => config_path('alipay/appPublicCert.crt'),
            // 必填-支付宝公钥证书 路径
            'alipay_public_cert_path' => config_path('alipay/alipayPublicCert.crt'),
            // 必填-支付宝根证书 路径
            'alipay_root_cert_path' => config_path('alipay/alipayRootCert.crt'),
            'return_url' => '',
            'notify_url' => '',
            // 选填-服务商模式下的服务商 id，当 mode 为 Pay::MODE_SERVICE 时使用该参数
            'service_provider_id' => '',
            // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE
            'mode' => Pay::MODE_NORMAL,
            'log'   => [
                'file'  => storage_path('logs/alipay.log')
            ]
        ],
    ],
    'wechat' => [
        'default' => [
            // 必填-商户号，服务商模式下为服务商商户号
            'mch_id' => '',
            // 必填-商户秘钥
            'mch_secret_key' => '',
            // 必填-商户私钥 字符串或路径
            'mch_secret_cert' => '',
            // 必填-商户公钥证书路径
            'mch_public_cert_path' => '',
            // 必填
            'notify_url' => '',
            // 选填-公众号 的 app_id
            'mp_app_id' => '',
            // 选填-小程序 的 app_id
            'mini_app_id' => '',
            // 选填-app 的 app_id
            'app_id' => '',
            // 选填-合单 app_id
            'combine_app_id' => '',
            // 选填-合单商户号
            'combine_mch_id' => '',
            // 选填-服务商模式下，子公众号 的 app_id
            'sub_mp_app_id' => '',
            // 选填-服务商模式下，子 app 的 app_id
            'sub_app_id' => '',
            // 选填-服务商模式下，子小程序 的 app_id
            'sub_mini_app_id' => '',
            // 选填-服务商模式下，子商户id
            'sub_mch_id' => '',
            // 选填-微信公钥证书路径, optional，强烈建议 php-fpm 模式下配置此参数
            'wechat_public_cert_path' => [
                '45F59D4DABF31918AFCEC556D5D2C6E376675D57' => __DIR__.'/Cert/wechatPublicKey.crt',
            ],
            // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SERVICE
            'mode' => Pay::MODE_NORMAL,
            'log'   => [
                'file'  => storage_path('logs/wechat_pay.log'),
            ],
        ],
    ],
    'unipay' => [
        'default' => [
            // 必填-商户号
            'mch_id' => '',
            // 必填-商户公私钥
            'mch_cert_path' => '',
            // 必填-商户公私钥密码
            'mch_cert_password' => '000000',
            // 必填-银联公钥证书路径
            'unipay_public_cert_path' => '',
            // 必填
            'return_url' => '',
            // 必填
            'notify_url' => '',
        ],
    ],
    'http' => [ // optional
        'timeout' => 5.0,
        'connect_timeout' => 5.0,
        // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
    ],
    // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
    'logger' => [
        'enable' => false,
        'file' => null,
        'level' => 'debug',
        'type' => 'single', // optional, 可选 daily.
        'max_file' => 30,
    ],
];
