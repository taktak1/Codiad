<html>
<font size=+9>
<?php

include_once('../../function.inc');

$mail=$_POST['mail'];
$user=$_POST['username'];
$password=$_POST['password'];


$password = strip_tags($password);
$password = trim($password );

$user = strip_tags($user);
$user = trim($user );

$mail = strip_tags($mail);
$mail = trim($mail );




if(   strlen( $user  )> 1  &&    strlen( $password  )> 1  &&    strlen( $mail  )> 1    ){

	$hash = hash(   "md5" ,     $user. $mail. $password   );


	$sql11 ="select  *  from     user    where     username=\"".   $user   ."\" "   ;
	$result11 = db_connect( $sql11 );
	if( $list11=mysql_fetch_array($result11) ) {

		echo  $user . "　はすでに使用されています。";
		exit( 0 );

	}



	$sql12 ="insert   into  user(username,mail,password,hash )  values( \"".     $user     ."\"  ,    \"".   $mail   ."\"    ,    \"".    $password    ."\"      ,    \"".    $hash    ."\"    ) ";
	db_connect( $sql12 );


	$sql13 ="select  *   from   user  where   username=\"".     $user     ."\"   and    hash =  \"".    $hash    ."\"   ";
	$result1 = db_connect( $sql13 );
	

	if( $list1=mysql_fetch_array($result1) ) {
		$id =  $list1['id'];

		$url= "http://domain/mailconfirm.php?num=".   $id   ."&args=".     $hash   ; 


		if (  mail(   $mail     , " title ", "  click  here  \n ".$url   ,  null   , "-fmail@domain"   )  ){
		  echo  $mail . "に確認用メールが送信されました。";
		} 

	}


}




?>

<hr>

<a href="/"> top  </a>

</font>
</html>
