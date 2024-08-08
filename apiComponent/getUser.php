<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-07-01 09:46:23
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */
function getUser(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    $operate_target = $args[2];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        $target_user = "user_id='$operate_target'";
        $is_admin = checkAdmin($operate_user);
        $sql_self = '`id`,`user_id`,`nickname`,`login_time`,`group`,`avatar`';
        if (!empty($operate_target)) {
            $pre_query = db_fetch_row("SELECT username,token FROM user where user_id='$operate_target';");
            if ($pre_query['username'] == $operate_user && $pre_query['token'] == $operate_token) {
                $sql_self = '*';
                $target_user = "username='$operate_user'";
            } else if (!$is_admin) {
                return alert_back("权限不足！", 0);
            } else {
                return alert_back("用户校验失败！", 0);
            }
        } else {
            $sql_self = '*';
            $target_user = "username='$operate_user'";
        }
        $select = db_fetch_row("SELECT $sql_self FROM user where $target_user;");
        if ($select) {
            return alert_back("OK", 1, $select);
        }
        return alert_back("用户不存在", 0);
    } else {
        return alert_back("用户校验失败", 0);
    }
}
