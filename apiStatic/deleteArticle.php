<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-26 17:22:46
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function deleteArticle(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        $article_id = input_post("id");
        $row_res = db_fetch_row("SELECT * FROM article WHERE article_id='$article_id'");
        // 获取用户详细信息
        $res = db_fetch_row("SELECT * FROM user where username='$operate_user';");
        $is_admin = checkAdmin($operate_user);
        if ($res && $row_res) {
            if ($is_admin) {
                db_query("DELETE FROM article where article_id='$article_id';");
                return alert_back("OK", 1);
            } else if ($row_res['author_id'] == $res['user_id']) {
                db_query("DELETE FROM article where article_id='$article_id';");
                return alert_back("OK", 1);
            } else {
                return alert_back("这不是你的文章，你无权删除", 0);
            }
        }
        return alert_back("用户或文章不存在", 0);
    }
    return alert_back("数据错误", 0);
}
