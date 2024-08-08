<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-07-04 09:30:59
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function deleteComment(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        $comment_id = input_post("id");
        $row_res = db_fetch_row("SELECT * FROM comment WHERE comment_id='$comment_id';");
        // 获取用户详细信息
        $res = db_fetch_row("SELECT * FROM user where username='$operate_user';");
        $is_admin = checkAdmin($operate_user);
        if ($res && $row_res) {
            if ($is_admin) {
                db_query("DELETE FROM comment where comment_id='$comment_id';");
                return alert_back("OK", 1);
            } else if ($row_res['comment_author_id'] == $res['user_id']) {
                db_query("DELETE FROM comment where comment_id='$comment_id';");
                return alert_back("OK", 1);
            } else {
                return alert_back("这不是你的评论，你无权删除", 0);
            }
        }
        return alert_back("用户不存在", 0);
    }
    return alert_back("数据错误", 0);
}
