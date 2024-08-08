<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-20 11:24:53
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */
date_default_timezone_set('PRC');
class MSingleton
{
    private static $__instance = null;
    private static $__link = null;
    private function __construct()
    {
    }
    private function __clone()
    {
    }
    public static function getInstance(): mysqli
    {
        if (empty(self::$__instance)) {
            self::$__instance = new self();
            self::$__link = mysqli_connect('localhost', 'root', 'xuranyyds', 'blog');
        }
        return self::$__link;
    }
}

function db_init()
{
    $link = MSingleton::getInstance();
    if (!$link) {
        exit('连接数据库失败!' . mysqli_connect_error());
    }
    mysqli_set_charset($link, 'utf8');
    return $link;
}
/**
 * @description: 执行SQL的方法
 * @param string $sql 待执行的SQL
 * @return mixed 失败返回false,成功，如果是查询语句返回结果集，如果非查询类返回true
 */
function db_query($sql)
{
    //执行SQL语句
    if ($result = mysqli_query(db_init(), $sql, MYSQLI_STORE_RESULT)) {
        return $result;
    } else {
        echo '错误的信息为:', $sql, '<br>';
        exit('SQL语句执行失败。');
    }
}
// 处理结果集中有多行数据的方法
// @param string $sql 待执行的SQL
// @return array 返回遍历结果集后的二维码
function db_fetch_all($sql)
{
    //执行query()函数
    if ($result = db_query($sql)) {
        //执行成功
        //遍历结果集
        if ($result) {
            $row = array();
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
            //释放结果集资源
            mysqli_free_result($result);
            return $rows;
        }
        return false;
    } else {
        //执行失败
        return false;
    }
}
// 处理结果集中只有一行数据的方法
// @param string $sql 待执行的SQL语句
// @return array 返回结果处理后的一维数组
function db_fetch_row($sql)
{
    //执行query()函数
    if ($result = db_query($sql)) {
        //从结果集取得一次数据即可
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row;
    } else {
        return false;
    }
}
// 处理结果集只有一个数据的方法
function db_fetch_column($sql)
{
    if ($result = db_query($sql)) {
        $row = mysqli_fetch_row($result);

        return $row[0];
    } else {
        return false;
    }
}
// 对数据进行SQL转义
// @param string $data 待转义字符串
// @return string 转义后的字符串

function db_escape($data)
{
    //转义字符串中的特殊字符
    return mysqli_real_escape_string(db_init(), $data);
}
