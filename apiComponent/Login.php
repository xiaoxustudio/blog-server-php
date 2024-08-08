<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-22 22:20:02
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */
require_once 'updateUser.php';
function Login(...$args)
{
    $name = $args[0];
    $pwd = $args[1];
    $fields = array('username' => $name, 'password' => $pwd);
    foreach ($fields as $k => $v) {
        $data = filter($v);
        if ($data == '') {
            alert_back($k . '字段不能为空', 0);
        }
    }
    $select = db_fetch_all("SELECT * FROM user where username='$name';");
    if (is_array($select)) {
        if (count($select) == 0) {
            return alert_back("账号不存在", 0);
        } else {
            $_data = $select[0];
            // 判断username 和 password
            if ($_data["username"] == $name && $_data["password"] == $pwd) {
                $new_token = generateToken($_data["username"]);
                $res = db_query("UPDATE user SET token= '$new_token' where  username='$name' and  password = '$pwd';");
                if ($res) {
                    db_query("UPDATE `user` SET login_time='" . date("Y-m-d H:i:s") . "' where username='$name';");
                    $new_res = db_fetch_row("SELECT * FROM user WHERE username='$name';");
                    // 登录成功，返回更新的token
                    return alert_back("OK", 1, $new_res);
                }
                return alert_back("登录异常", 0);
            } else {
                return alert_back("账号或密码错误", 0);
            }
        }
    }
    return alert_back("账号不存在", 0);
}
