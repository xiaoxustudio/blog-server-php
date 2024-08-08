<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-07-01 11:18:08
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function getMyCommentList()
{
    $author_id = input_post("id");
    $sql = "WHERE comment_author_id='$author_id'";
    $res = db_fetch_all("SELECT * FROM comment $sql;");
    $_arr = array();
    foreach ($res as $v) {
        $comment_author_id = $v['comment_author_id'];
        $v['$user'] = db_fetch_row("SELECT `id`,`user_id`,`nickname`,`username`,`login_time`,`group`,`avatar` FROM user WHERE user_id='$comment_author_id' ;");
        $_arr[] = $v;
    }
    return alert_back("OK", 1, $_arr);
}
