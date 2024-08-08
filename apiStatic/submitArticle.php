<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-06-24 10:10:59
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */

function submitArticle(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        // 解析为json
        $data = json_decode(str_replace('\\', '', input_post('data')));
        // 验证文章有效性
        if (strlen($data->title) <= 1) {
            return alert_back("标题字段长度太小", 0, $data);
        } else if (strlen($data->content) <= 1) {
            return alert_back("字段长度太小", 0, $data);
        }
        $a_id =  mt_rand(11111, 9999999); // 文章id
        $a_time =  date("Y-m-d H:i:s", time()); // 文章时间
        // 获取用户详细信息
        $res = db_fetch_row("SELECT * FROM user where username='$operate_user';");
        if ($res) {
            $user_id = $res['user_id'];
            $prefiex = "(`article_id`,`article_class`,`article_title`,`article_content`,`article_see`,`article_time`,`author_id`,`article_tags`)";
            $suffix = "('$a_id','$data->class','$data->title','" . db_escape($data->content) . "','0','$a_time','$user_id','$data->tags')";
            $a_res = db_query("INSERT INTO article $prefiex  values $suffix;");
            if ($a_res) {
                return alert_back("OK", 1);
            } else {
                return alert_back("发布文章失败！", 0);
            }
        }
        return alert_back("用户不存在", 0);
    }
    return alert_back("数据错误", 0);
}
