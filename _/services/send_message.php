<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])){
  $name = htmlentities($_POST["name"]);
  $email = htmlentities($_POST["email"]);
  $message = $_POST["message"];
  $message = str_replace(array("\r\n", "\n", "\r"), "<br>", $message);

  $message = htmlentities($message);

  $message = str_replace("&lt;br&gt;", "<br>", $message);

  if(isset($name[0]) && isset($email[0]) && isset($message[0])){

      $hds = "From: $SITE_NAME <$SUPPORT_EMAIL>\nX-Mailer: PHP/".phpversion()
        . "\nReply-To: $SUPPORT_EMAIL\nX-Priority: 3\nMIME-Version: 1.0\nContent-type: text/html; charset=utf-8\n";

      $msgH = '<html><head><title>' . $SITE_NAME . '</title></head><body><table width="100%" border="0" cellpadding=0 cellspacing=0><tr height=5><td width="8"></td><td></td></tr><tr><td width="8"></td><td><font style="font-family:Tahoma;font-size:14px">' . $SITE_NAME . ' - Message from ' . $name . '</font></td></tr><tr height="40"><td colspan=2></td></tr><tr><td></td><td><font style="font-family:Tahoma;font-size:12px">';
      $msgF .= '</font></td></tr></table></body ></html>';


      $msg .= "The following message was sent from " . $name . " (" . $email . ").<br>" . $message;

      $subject = "Message sent from " . $name;

      $msg=$msgH.$msg.$msgF;

      @mail($ADMIN_EMAIL, $subject, $msg, $hds);

      $arr=array('result'=>'success');
  }else{
    $arr=array('result'=>'error','error_msg'=>'params_missing');
  }
}else{
  $arr=array('result'=>'error','error_msg'=>'params_missing');
}

closeConnections();

echo json_encode($arr);