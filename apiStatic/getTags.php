<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-24 09:25:27
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function getTags()
{
    $res = db_fetch_all('SELECT article_tags FROM article');
    if ($res) {
        $_arr = array();
        foreach ($res as $v) {
            $_arr = array_merge($_arr, explode('|', $v['article_tags']));
        }
        $_arr = array_unique($_arr); // 去重
        return alert_back('OK', 1, $_arr);
    }
    return alert_back('失败', 0);
}
