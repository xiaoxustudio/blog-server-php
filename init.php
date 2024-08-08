<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-07-01 19:45:48
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

//设置字符集
header('Content-Type:text/html;charset-utf-8');

// //开启调试模式
// define('DB_DEBUG', ture);

//加载数据库操作函数库
require './lib/db_function.php';

//初始化数据库
db_init();

//接受GET变量
function input_get($name)
{
    return isset($_GET[$name]) ? db_escape($_GET[$name]) : '';
}

//接收POST变量
function input_post($name)
{
    return isset($_POST[$name]) ? db_escape($_POST[$name])  : '';
}
// 对字符串数据进行过滤
// @param string $data 待转义字符串
// @return string 转义后的字符串
function filter($data, $func = array('trim', 'htmlspecialchars'))
{
    foreach ($func as $v) {
        // 调用可变函数过滤数据
        $data = $v((string)$data);
    }
    return $data;
}


/**
 * @description: 回调数据
 * @param {*} $msg 返回消息
 * @param {*} $status 状态码
 * @param {*} $data json数据
 * @return {*}
 */
function alert_back($msg, $status = 1, $data = array())
{
    echo json_encode(array("msg" => $msg, "status" => $status, "data" => $data), JSON_UNESCAPED_UNICODE);
    exit;
}
define('Token_Key', 'XuranYYDS');
// 加密函数
function encrypt($string, $key = Token_Key)
{
    $ivlen = openssl_cipher_iv_length('aes-128-cbc');
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($string, 'aes-128-cbc', $key, 0, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
    $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
    return $ciphertext;
}

// 解密函数
function decrypt($ciphertext, $key = Token_Key)
{
    $c = base64_decode($ciphertext);
    $ivlen = openssl_cipher_iv_length('aes-128-cbc');
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len = 32);
    $ciphertext_raw = substr($c, $ivlen + $sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, 'aes-128-cbc', $key, 0, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
    if (hash_equals($hmac, $calcmac)) {
        return $original_plaintext;
    }
    return false;
}

/**
 * @description: 生成Token
 * @param {*} $userid
 * @return {*}
 */
function generateToken($userid)
{
    $time = time();
    $end_time = time() + 86400;
    $info = $userid . '.' . $time . '.' . $end_time;
    return encrypt($info);
}

/**
 * @description: 解密token
 * @param {*} $userid
 * @param {*} $token
 * @return {*}
 */
function validToken($userid, $token)
{
    $d = decrypt($token);
    $explode = explode('.', $d);
    if (
        !empty($explode[0]) && !empty($explode[1]) && !empty($explode[2])
    ) {
        if (time() > $explode[2]) {
            // Token已过期,请重新登录
            return false;
        }
        if (time() < $explode[1]) {
            // Token不合法
            return false;
        } else if ($userid == $explode[0]) {
            return true;
        } else {
            // 不是自己的token
            return false;
        }
    } else {
        return false;
    }
}
