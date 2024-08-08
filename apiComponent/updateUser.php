<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-25 11:03:52
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function updateUser(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    $target_name = $args[2];
    $target_val = $args[3];
    $id = $args[4];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        // 允许修改用户属性
        $_arr = array('nickname', 'password', 'username');
        $check = in_array($target_name, $_arr);
        $pre_res = db_fetch_row("SELECT * FROM user WHERE username='$operate_user' AND user_id='$id';");
        $is_admin = checkAdmin($operate_user);
        if (!$pre_res && !$is_admin) {
            return alert_back("无权修改", 0);
        } else if ($check) {
            $res = db_query("UPDATE user SET $target_name='$target_val' where user_id='$id';");
            if ($res) {
                return alert_back("OK", 1);
            }
            return alert_back("修改失败", 0);
        } else {
            return alert_back("修改失败，字段范围超出", 0);
        }
    }
    return alert_back("数据错误", 0);
}
