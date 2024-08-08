<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-21 11:00:38
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

// 获取分类列表不需要传参
function getClassList()
{
    $res = db_fetch_all("SELECT * FROM class;");
    return alert_back("OK", 1, $res);
}
