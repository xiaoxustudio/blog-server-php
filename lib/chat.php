<?php
global $file_chat, $file_dir;
$file_chat = './chat/chat.json'; // 数据文件
$_dir_arr = preg_split("/\//", $file_chat);
$_dir = array_splice($_dir_arr, 0, count($_dir_arr) - 1);
$file_dir = implode('/', $_dir);
if (!file_exists($file_dir)) {
    mkdir($file_dir, 0777, true);
}
if (!file_exists($file_chat)) {
    file_put_contents($file_chat, '[]');
}
function getChatList()
{
    $chat_text = file_get_contents($GLOBALS['file_chat']);
    $chat_data = json_decode($chat_text, true);
    $users = array();
    $_arr = array();
    foreach ($chat_data as $k => $v) {
        $user_id = $v['user_id'];
        $pre = db_fetch_row("SELECT * FROM user where user_id='$user_id';");
        if ($pre) {
            $v['$user'] = $pre;
        }
        $_arr[] = $v;
    }
    return alert_back("ok", 1, $_arr);
}
function addMessage(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        $msg = input_post('msg');
        $pre = db_fetch_row("SELECT * FROM user where username='$operate_user';");
        $chat_text = file_get_contents($GLOBALS['file_chat']);
        $chat_data = json_decode($chat_text, true);
        $chat_data[] = array('user_id' => $pre['user_id'], 'msg' => $msg, 'time' => date("Y-m-d H:i:s"));
        file_put_contents($GLOBALS['file_chat'], json_encode($chat_data));
        return alert_back("ok", 1);
    }
}
function clearChat(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        if (!checkAdmin($operate_user)) {
            return alert_back("您无权清空聊天", 0);
        }
        file_put_contents($GLOBALS['file_chat'], '[]');
        return alert_back("ok", 1);
    }
}
