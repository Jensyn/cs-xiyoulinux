<?php
session_start();
require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once(BASE_PATH . '/includes/mail.class.php');


$json_error = json_encode(array("result"=>"false"));

if ( !isset($_POST['action']) ) {
    echo $json_error;
    exit;
}

if ( !isset($_COOKIE['uid'])) {
    echo $json_error;
    exit;
}

$mailObj = new MailClass($_COOKIE['uid']);
$action = $_POST['action'];


switch( $action ) {
    case "del_mail":
        if( isset($_POST['mid']) ) {
            echo $mailObj->del_mail($_POST['mid']);
            exit;
        }
        break;
    case "send_mail":    //发送邮件 当包含mid时只做更新不做插入
        $title = $_POST['title'];
        $title = htmlentities($title, ENT_QUOTES, 'UTF-8');
        $touser = $_POST['touser'];
        $content = $_POST['content'];
        //$content = htmlentities($content, ENT_QUOTES, 'UTF-8');
        //这里需要用白名单过滤特殊字符，后期需要添加处理，防止xss
	if ( isset($_POST['mid']) ) {
            echo $mailObj->del_mail($title, $touser, $content, $_POST['mid']);
        }
        else {
            echo $mailObj->send_mail($title, $touser, $content);
        }
        exit;
        break;
    case "auto_complete":    //发送邮件时根据用户输入自动匹配
        $username = $_POST['username'];
        echo $mailObj->get_name_match($username);
        exit;
        break;
    case "save_draft":
        echo $mailObj->save_draft();
        exit;
        break;
}
?>
