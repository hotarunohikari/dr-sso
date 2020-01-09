# sso
single sign on
配合TP5使用，redis缓存token,用于单点登录,只做token数据存取并提供部分接口,不做具体业务

1. 对外接口使用示例：

```
<?php
use dr\tp5\sso\SSO;
class Index
{
   SSO::getToken($id); //获取指定ID的token,不存在则返回false
   SSO::setToken($id, $token); //设置指定ID的token值,如果ID已经有值则不进行赋值操作，设置成功返回true,否则返回false
   SSO::setTokenForce($id, $token); // 强制设置指定ID的token值,设置成功返回true,否则返回false
   SSO::conflict($id, $token); // 检查已有token是否和给定token冲突,若冲突则返回true,否则返回false
   SSO::pullToken($id); //取出指定ID的token并删除，不存在则返回false
   SSO::delToken($id); //删除指定ID的token,删除成功返回true,否则返回false
}
```
2. 配置文件使用示例(可选)：

以TP5.1为例,在框架的config目录中新建php文件,命名为sso.php, 文件中写入如下内容：

```
   return [
        'expire'     => 60 * 60 * 120, // token缓存时间
        'sso'        => 'sso',         // 指定redis中存储token的namespace
        'host'       => '127.0.0.1',   // 以下为redis连接相关信息...
        'port'       => 6379,
        'password'   => '',
        'select'     => 0,
        'timeout'    => 0,
        'persistent' => false,
   ];
 ```
 
   默认的缓存时间为12小时
