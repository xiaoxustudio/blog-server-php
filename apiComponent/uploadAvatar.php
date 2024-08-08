<?php
/*
 * @Author: xuranXYS
 * @LastEditTime: 2024-07-01 09:33:59
 * @GitHub: www.github.com/xiaoxustudio
 * @WebSite: www.xiaoxustudio.top
 * @Description: By xuranXYS
 */
function upload_check($file)
{
    $error = isset($file['error']) ? $file['error'] : UPLOAD_ERR_NO_FILE;
    switch ($error) {
        case UPLOAD_ERR_OK:
            return is_uploaded_file($file['tmp_name']) ?: '非法文件';
        case UPLOAD_ERR_INI_SIZE:
            return '文件大小超过了服务器设置的限制！';
        case UPLOAD_ERR_FORM_SIZE:
            return '文件大小超过了表单设置的限制！';
        case UPLOAD_ERR_PARTIAL:
            return '文件只有部分被上传！';
        case UPLOAD_ERR_NO_FILE:
            return '没有文件被上传！';
        case UPLOAD_ERR_NO_TMP_DIR:
            return '上传文件临时目录不存在！';
        case UPLOAD_ERR_CANT_WRITE:
            return '文件写入失败！';
        default:
            return '未知错误';
    }
}
/**
 * 上传图片
 * @param array $file 上传文件 $_FILES['xx'] 数组
 */
function uploadAvatar(...$args)
{
    $operate_token = $args[0];
    $operate_user = $args[1];
    $user_id = $args[2];
    $file = $args[3];
    if (empty($operate_token) || empty($operate_user)) {
        return alert_back("缺少参数", 0);
    } else if (validToken($operate_user, $operate_token)) {
        // 检查文件是否上传成功
        if (true !== ($error = upload_check($file))) {
            return alert_back("文件上传失败：$error", 0, [$_FILES]);
        }
        // 检查文件类型是否正确
        $ext = array('image/jpeg', 'image/png');
        if (!in_array($file['type'], $ext)) {
            return alert_back('文件上传失败：只允许扩展名：' . implode(', ', $ext), 0);
        }
        $ext_name = explode('/', $file['type'])[1];
        // 生成文件名和保存路径                   // 生成子目录
        $new_name = $user_id . '-' . $operate_user . ".$ext_name";     // 生成文件名
        // 创建原图保存目录
        $upload_dir = "./uploads/";
        if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true)) {
            return alert_back('文件上传失败：无法创建保存目录！', 0);
        }
        // 保存上传文件
        if (!move_uploaded_file($file['tmp_name'], "$upload_dir/$new_name")) {
            return alert_back('文件上传失败：无法保存文件！', 0);
        }
        $pre_query = db_fetch_row("SELECT username,token FROM user where user_id='$user_id';");
        if ($pre_query) {
            // 保存到数据库
            $path = "$new_name";
            $query = db_query("UPDATE user SET avatar='$path' where user_id='$user_id';");
            if ($query) {
                return alert_back('OK', 1, $file);
            } else {
                return alert_back('文件上传失败', 0);
            }
        } else {
            return alert_back('文件上传失败：无该用户！', 0);
        }
    }
    return alert_back("数据错误", 0);
}
