 <?php
/************************************************新邮件数目************************************************
输出未读邮件数目，比如说有5份未读信件，就输出：5
*****************************************************************************************************************/
$mailClass = new Mail($_SESSION['uid']);

$mail_num = $mailClass->get_mail_num(1);
echo $mail_num;
?>



