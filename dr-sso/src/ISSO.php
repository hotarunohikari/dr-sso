<?php
/**
 * author      : Qttx 摩羯Ж'
 * mtime       : 2020/1/9 13:56
 * description :
 */

namespace dr\tp5\sso;

// 单点登录
interface ISSO
{

    // 存储登录状态,若已登录则不操作
    public function getToken($id);

    // 存储登录状态,若已登录则不操作
    public function setToken($id, $token);

    // 强制覆盖
    public function setTokenForce($id, $token);

    // 检查是否冲突
    public function conflict($id, $token): bool;

    // 取出token 并清空
    public function pullToken($id);

    // 删除token
    public function delToken($id);

}