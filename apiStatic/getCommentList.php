<?php

// 获取分类列表不需要传参
function getCommentList()
{
    $article_id = input_post("article_id");
    $sql = isset($article_id) && $article_id != '' ? "WHERE article_id='$article_id'" : '';
    $res = db_fetch_all("SELECT * FROM comment $sql;");
    $_arr = array();
    foreach ($res as $v) {
        $comment_author_id = $v['comment_author_id'];
        $v['$user'] = db_fetch_row("SELECT `id`,`user_id`,`nickname`,`username`,`login_time`,`group` FROM user WHERE user_id='$comment_author_id' ;");
        $_arr[] = $v;
    }
    return alert_back("OK", 1, $_arr);
}
