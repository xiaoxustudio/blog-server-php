<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-22 22:04:28
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function getUserList(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        if (!checkAdmin($operate_user)) {
            return alert_back("权限不足", 0);
        }
        // 获取用户列表
        $res = db_fetch_all("SELECT * FROM user;");
        if ($res) {
            return alert_back("OK", 1, $res);
        }
    }
    return alert_back("数据错误", 0);
}
