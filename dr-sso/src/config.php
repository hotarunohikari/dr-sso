<?php
/**
 * author      : Qttx 摩羯Ж'
 * mtime       : 2020/1/9 14:37
 * description :
 */
return [
    'connector'  => 'Redis',        // Redis 驱动
    'expire'     => 60*60*12,        // 有效时间
    'sso'    => 'sso',        // 默认的队列名称
    'host'       => '127.0.0.1',    // redis 主机ip
    'port'       => 6379,        // redis 端口
    'password'   => '',        // redis 密码
    'select'     => 0,        // 使用哪一个 db，默认为 db0
    'timeout'    => 0,        // redis连接的超时时间
    'persistent' => false,        // 是否是长连接
];