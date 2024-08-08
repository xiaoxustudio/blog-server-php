<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-23 00:04:21
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function addComment(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        // 解析为json
        $article_id = input_post('article_id');
        $author_id = input_post('author_id');
        $content = input_post('content');
        // 验证评论有效性
        if (strlen($article_id) <= 1 || strlen($content) <= 1) {
            return alert_back("数据校验错误", 0);
        }
        $a_id =  mt_rand(11111, 9999999); // 评论id
        $a_time =  date("Y-m-d H:i:s", time()); // 评论时间
        // 获取用户详细信息
        $res = db_fetch_row("SELECT * FROM user where username='$operate_user';");
        if ($res) {
            $prefiex = "(`comment_id`,`comment_content`,`comment_like`,`comment_author_id`,`comment_article_id`,`comment_time`)";
            $suffix = "('$a_id','" . db_escape($content) . "','','$author_id','$article_id','$a_time')";
            $a_res = db_query("INSERT INTO comment $prefiex  values $suffix;");
            if ($a_res) {
                return alert_back("OK", 1);
            } else {
                return alert_back("发布评论失败！", 0);
            }
        }
        return alert_back("用户不存在", 0);
    }
    return alert_back("数据错误", 0);
}
