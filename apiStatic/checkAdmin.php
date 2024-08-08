<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-04-12 14:25:23
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function checkAdministrator(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        if (checkAdmin($operate_user) == false) {
            return alert_back("权限不足", 0);
        } else {
            return alert_back("OK", 1);
        }
    }
    return alert_back("数据错误", 0);
}
