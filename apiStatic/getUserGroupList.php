<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-01 13:30:58
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function getUserGroupList(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        // 获取用户列表
        $res = db_fetch_all("SELECT id,`group` FROM `user` GROUP BY `group`;");
        return alert_back("OK", 1, $res);
    }
    return alert_back("数据错误", 0);
}
