<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-07-01 09:24:25
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */
header('Content-Type:text/html;charset-utf-8');
require_once './init.php';
require_once "./apiComponent/checkAdmin.php";
require_once './apiComponent/Login.php';
require_once './apiComponent/getUser.php';
require_once './apiComponent/addUser.php';
require_once './apiComponent/getUserList.php';
require_once './apiComponent/updateUser.php';
require_once './apiComponent/updatesUser.php';
require_once './apiComponent/updateArticle.php';
require_once './apiComponent/deleteUser.php';
require_once './apiComponent/uploadAvatar.php';

require_once './apiStatic/getClassList.php';
require_once './apiStatic/getArticleList.php';
require_once './apiStatic/getCommentList.php';
require_once './apiStatic/getArticle.php';
require_once './apiStatic/getMyArticle.php';
require_once './apiStatic/getMyCommentList.php';
require_once './apiStatic/getClass.php';
require_once './apiStatic/getTags.php';
require_once './apiStatic/submitArticle.php';
require_once './apiStatic/submitSearch.php';
require_once './apiStatic/addComment.php';
require_once './apiStatic/deleteComment.php';
require_once './apiStatic/deleteArticle.php';
require_once './apiStatic/addCommentLike.php';
require_once './apiStatic/updatesArticle.php';
require_once './apiStatic/updatesComment.php';
require_once './apiStatic/getUserGroupList.php';
require_once './apiStatic/checkToken.php';
require_once './apiStatic/checkAdmin.php';

require_once './lib/chat.php';

$type = input_get("type");
$id = input_post("id");
$target_name = input_post("tname");
$target_val = input_post("tvalue");
$operate_user = input_post("username");
$operate_token = input_post("token");
$name = input_post("username");
$pwd = input_post("password");
// http://xxx/api.php?type=loginUser
// POST username password
switch ($type) {
    case "getUserList":
        return getUserList($operate_token, $operate_user);
    case "getUserGroupList":
        return getUserGroupList($operate_token, $operate_user);
    case "updateUser":
        return updateUser($operate_token, $operate_user, $target_name, $target_val, $id);
    case "updateArticle":
        return updateArticle($operate_token, $operate_user, $target_name, $target_val, $id);
    case "deleteUser":
        return deleteUser($operate_token, $operate_user, $id);
    case "updatesUser":
        return updatesUser($operate_token, $operate_user);
    case "getUser":
        return getUser($operate_token, $operate_user, $id);
    case "uploadAvatar":
        return uploadAvatar($operate_token, $operate_user, $id, $_FILES['avatar_file']);
    case "addUser":
        return addUser();
    case "loginUser":
        return Login($name, $pwd);
    case "getClassList":
        return getClassList();
    case "getClass":
        return getClass();
    case "getTags":
        return getTags();
    case "getArticleList":
        return getArticleList();
    case "getCommentList":
        return getCommentList();
    case "getArticle":
        return getArticle();
    case "getMyArticle":
        return getMyArticle();
    case "getMyCommentList":
        return getMyCommentList();
    case "submitArticle":
        return submitArticle($operate_token, $operate_user);
    case "submitSearch":
        return submitSearch();
    case "addComment":
        return addComment($operate_token, $operate_user);
    case "deleteComment":
        return deleteComment($operate_token, $operate_user);
    case "addCommentLike":
        return addCommentLike($operate_token, $operate_user);
    case "updatesArticle":
        return updatesArticle($operate_token, $operate_user);
    case "updatesComment":
        return updatesComment($operate_token, $operate_user);
    case "deleteArticle":
        return deleteArticle($operate_token, $operate_user);
    case "checkToken":
        return checkToken($operate_token, $operate_user);
    case "checkAdmin":
        return checkAdministrator($operate_token, $operate_user);
    case "getChatList":
        return getChatList();
    case "addMessage":
        return addMessage($operate_token, $operate_user);
    case "clearChat":
        return clearChat($operate_token, $operate_user);
    default:
        return alert_back("接口调用失败", 0);
}
