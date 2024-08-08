<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-04-12 14:52:54
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function checkAdmin($operate_user)
{
    if (empty($operate_user)) {
        return false;
    } else {
        // 获取用户详细信息
        $res = db_query("SELECT * FROM user where username='$operate_user' and `group`=0;");
        if (mysqli_num_rows($res) > 0) {
            return true;
        }
        return false;
    }
    return false;
}
