<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-25 16:28:13
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function updateArticle(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    $target_name = $args[2];
    $target_val = $args[3];
    $id = $args[4];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        // 允许修改文章属性
        $_arr = array('article_title', 'article_content', 'article_tags');
        $check = in_array($target_name, $_arr);
        $pre_res = db_fetch_row("SELECT * FROM user WHERE username='$operate_user';");
        $user_id = $pre_res['user_id'];
        $pre_res1 = db_fetch_row("SELECT * FROM article WHERE article_id='$id' AND author_id='$user_id';");
        $is_admin = checkAdmin($operate_user);
        if (!$pre_res1 && !$pre_res && !$is_admin) {
            return alert_back("数据异常！", 0);
        } else if ($check) {
            $res = db_query("UPDATE article SET $target_name='$target_val' where article_id='$id';");
            if ($res) {
                return alert_back("OK", 1);
            }
            return alert_back("修改失败", 0);
        } else {
            return alert_back("修改失败，文章字段范围超出" . $target_name, 0);
        }
    }
    return alert_back("数据错误", 0);
}
