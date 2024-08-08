<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-21 10:09:47
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

// 获取文章列表不需要传参
function getArticleList()
{
    $group = input_post("group");
    $sql = isset($group) && $group != '' ? "WHERE article_class='$group'" : '';
    $res = db_fetch_all("SELECT * FROM article $sql;") ?: array();
    $_arr = array();
    foreach ($res as $v) {
        $class_id = $v['article_class'];
        $author_id = $v['author_id'];
        $v['$user'] = db_fetch_row("SELECT * FROM user WHERE user_id='$author_id';");
        $v['$class'] = db_fetch_row("SELECT * FROM class WHERE class_id='$class_id';");
        $_arr[] = $v;
    }
    return alert_back("OK", 1, $_arr);
}
