<?php
/**
 * author      : Qttx 摩羯Ж'
 * mtime       : 2020/1/9 14:22
 * description : 单点登录的redis连接实现
 */

namespace dr\tp5\sso\connector;

use dr\tp5\sso\ISSO;
use Exception;

class Redis implements ISSO
{
    protected $redis;

    private $options = [
        'expire'     => 60 * 60 * 120,
        'sso'        => 'sso',
        'host'       => '127.0.0.1',
        'port'       => 6379,
        'password'   => '',
        'select'     => 0,
        'timeout'    => 0,
        'persistent' => false,
    ];

    public function __construct($options) {

        if (!extension_loaded('redis')) {
            throw new Exception('redis扩展未安装');
        }
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }

        $func        = $this->options['persistent'] ? 'pconnect' : 'connect';
        $this->redis = new \Redis;
        $this->redis->$func($this->options['host'], $this->options['port'], $this->options['timeout']);

        if ('' != $this->options['password']) {
            $this->redis->auth($this->options['password']);
        }

        if (0 != $this->options['select']) {
            $this->redis->select($this->options['select']);
        }
    }


    public function getToken($id) {
        return $this->redis->hGet($this->options['sso'], $id);
    }

    public function setToken($id, $token) {
        return !$this->redis->hSetNx($this->options['sso'], $id, $token);
    }

    public function setTokenForce($id, $token) {
        return 0 === $this->redis->hSet($this->options['sso'], $id, $token);
    }

    public function conflict($id, $token): bool {
        return $this->redis->hGet($this->options['sso'], $id) != $token;
    }


}