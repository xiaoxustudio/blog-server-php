<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-20 12:53:26
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function addUser()
{
    // 注册用户
    $fields = array('username', 'password');
    $_info = array(
        mt_rand(11111, 9999999),
        "'默认用户" . time() . "'",
    );
    foreach ($fields as $k => $v) {
        $data = input_post($v);
        $data = filter($data);
        if ($data == '') {
            alert_back($v . '字段不能为空' . $data, 0);
        }
        $fields[$k] = "`$v`";    //把字段使用反引号包裹
        $_info[] = "'$data'";   //把值使用单引号包裹
    }
    // 重复注册
    $name = input_post("username");
    $select = db_fetch_all("SELECT * FROM user where username='$name';");
    if (is_array($select) && count($select) > 0) {
        return alert_back("重复注册", 0);
    }
    $_info[] = "'" . date("Y-m-d H:i:s", time()) . "'"; // 设置最后登录时间
    $_info[] = "'0'";   //设置组
    $_info[] = "'" . generateToken(input_post("username")) . "'"; // 生成token
    $_s = join(",", $_info);
    $res = db_query("INSERT into user (`user_id`,`nickname`,`username`,`password`,`login_time`,`group`,`token`) values ($_s);");
    if ($res) {
        return alert_back("OK", 1, $res);
    }
    return alert_back("注册失败", 0);
}
