<?php

function addCommentLike(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        // 解析为json
        $comment_id = input_post('comment_id');
        // 验证评论有效性
        if (empty($comment_id)) {
            return alert_back("评论ID错误", 0);
        }
        // 获取用户详细信息
        $res = db_fetch_row("SELECT * FROM user where username='$operate_user';");
        $c_res = db_fetch_row("SELECT * FROM comment where comment_id='$comment_id';");
        $_arr = explode("|", $c_res['comment_like']) ?? [];
        if ($res) {
            // 重复点赞
            if (in_array($res['user_id'], $_arr, true)) {
                return alert_back("请勿重复点赞！", 0);
            }
            $_arr[] = $res['user_id'];
            $c_like = implode('|', $_arr);
            $a_res = db_query("UPDATE comment SET comment_like='$c_like' WHERE comment_id='$comment_id' ;");
            if ($a_res) {
                return alert_back("OK", 1, $_arr);
            } else {
                return alert_back("点赞失败！", 0);
            }
        }
        return alert_back("用户不存在", 0);
    }
    return alert_back("数据错误", 0);
}
