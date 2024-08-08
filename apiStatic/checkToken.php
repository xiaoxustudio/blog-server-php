<?php

function checkToken(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        return alert_back("OK", 1);
    }
    return alert_back("数据错误", 0);
}
