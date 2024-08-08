<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-07-01 19:42:35
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function updatesUser(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        // 解析为json
        $data = json_decode(str_replace('\\', '', input_post('data')));
        $_allowed_property = array('nickname', 'username', 'password', 'group', 'login_time');
        $is_admin = checkAdmin($operate_user);
        $sql_text = "";
        foreach ($data as $key => $val) {
            $check = in_array($key, $_allowed_property);
            if ($check) {
                $sql_text .= "`$key`='$val',";
            }
        }
        $sql_text = substr($sql_text, 0, strlen($sql_text) - 1);
        if (!$is_admin) {
            return alert_back("修改失败，权限不足", 0);
        } else {
            $user_id = $data->user_id;
            $res = db_query("UPDATE user SET $sql_text where user_id='$user_id';");
            if ($res) {
                return alert_back("OK", 1);
            }
            return alert_back("修改失败", 0);
        }
    }
    return alert_back("数据错误", 0);
}
