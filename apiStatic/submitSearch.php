<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-07-01 19:44:04
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function submitSearch()
{
    $title = input_post("title");
    $sql = isset($title) && $title != '' ? "WHERE article_title like '%$title%'" : '';
    $res = db_fetch_all("SELECT * FROM article $sql;");
    if ($res) {
        $_arr = array();
        foreach ($res as $v) {
            $class_id = $v['article_class'];
            $article_id = $v['article_id'];
            $author_id = $v['author_id'];
            $v['$user'] = db_fetch_row("SELECT `id`,`user_id`,`nickname`,`username`,`login_time`,`group` FROM user WHERE user_id='$author_id' ;");
            $v['$class'] = db_fetch_row("SELECT * FROM class WHERE class_id='$class_id';");
            $sql = isset($article_id) && $article_id != '' ? "WHERE comment_article_id='$article_id'" : '';
            $v['$comments'] = db_fetch_all("SELECT * FROM comment $sql;") ?? [];
            foreach ($v['$comments'] as $comment_k => $comment_v) {
                $comment_id = $comment_v['comment_id'];
                $comment_author_id = $comment_v['comment_author_id'];
                $comment_v['$user'] = db_fetch_row("SELECT `id`,`user_id`,`nickname`,`username`,`login_time`,`group` FROM user WHERE user_id='$comment_author_id';") ?? false;
                // 删除无效评论
                if ($comment_v['$user']) {
                    $v['$comments'][$comment_k] = $comment_v;
                } else {
                    db_query("DELETE FROM comment WHERE comment_id='$comment_id'");
                    unset($v['$comments'][$comment_k]);
                }
            }
            $_arr[] = $v;
        }
        return alert_back("OK", 1, $_arr);
    } else {
        return alert_back("未找到任何文章！", 0, $res);
    }
}
