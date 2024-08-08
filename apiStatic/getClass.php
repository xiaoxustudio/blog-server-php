<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-21 11:20:35
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

// 获取分类列表不需要传参
function getClass()
{
    $class_id = input_post("class_id");
    $sql = isset($class_id) && $class_id != '' ? "WHERE class_id='$class_id'" : '';
    $res = db_fetch_all("SELECT * FROM class $sql;");
    if ($res) {
        return alert_back("OK", 1, $res);
    } else {
        return alert_back("未找到分类！", 0, $res);
    }
}
