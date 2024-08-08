<?php

function deleteUser(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    $id = $args[2];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        if (!checkAdmin($operate_user)) {
            return alert_back("权限不足", 0);
        }
        $res = db_query("DELETE FROM user where user_id='$id';");
        if ($res) {
            return alert_back("OK", 1, $res);
        }
        return alert_back("用户不存在", 0);
    }
    return alert_back("数据错误", 0);
}
