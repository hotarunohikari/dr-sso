<?php
/**
 * author      : Qttx 摩羯Ж'
 * mtime       : 2020/1/9 13:52
 * description : 单点登录的主类
 */

namespace dr\tp5\sso;

use think\helper\Str;

class SSO
{

    private static $instance;
    private $connector;

    public static function instance() {
        if (null == static::$instance) {
            return new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->connector = $this->buildConnector();
    }

    protected function buildConnector() {
        $options = config('sso');
        $type    = !empty($options['connector']) ? $options['connector'] : 'Redis';
        if (!isset($this->connector)) {
            $class           = false !== strpos($type, '\\') ? $type : '\\dr\\tp5\\sso\\connector\\' . Str::studly($type);
            $this->connector = new $class($options);
        }
        return $this->connector;
    }

    private function __clone() {

    }

    public function __wakeup() {
        self::$instance = $this;
    }

    public function __destruct() {
        self::$instance = NULL;
    }

    public static function __callStatic($name, $arguments) {
        return call_user_func_array([self::instance()->connector, $name], $arguments);
    }

}