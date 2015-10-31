<html>
<font size=+9>
<?php

include_once('../../function.inc');



         function saveJSON($file,$data,$namespace=""){
            $path =   "./data/";
            if($namespace != ""){
                $path = $path . $namespace . "/";
                $path = preg_replace('#/+#','/',$path);
                if(!is_dir($path)) mkdir($path);
            }

            $data = "<?php/*|" . json_encode($data) . "|*/?>";
            $write = fopen($path . $file, 'w') or die("can't open file ".$path.$file);
            fwrite($write, $data);
            fclose($write);
        }

         function getJSON($file,$namespace=""){
            $path =  "./data/";
            if($namespace != ""){
                $path = $path . $namespace . "/";
                $path = preg_replace('#/+#','/',$path);
            }
            $json = file_get_contents($path . $file);
            $json = str_replace("|*/?>","",str_replace("<?php/*|","",$json));
            $json = json_decode($json,true);
            return $json;
        }





$args=$_GET['args'];
$num=$_GET['num'];



$num = strip_tags($num);
$num = trim($num );

$args = strip_tags($args);
$args = trim($args );





	$sql12 ="select  *  from     user    where    length(  password ) > 2    and   hash=\"".   $args   ."\"   and  id = ".    $num  ;
	$result1 = db_connect( $sql12 );



	if( $list1=mysql_fetch_array($result1) ) {



		$password =  $list1['password'];
		$username =  $list1['username'];
		$sql13 ="update  user   set  password=\"\"    where   id = ".    $num  ;
		db_connect( $sql13 );




        $password = sha1(md5($password));
        $users = getJSON('users.php');
 	$projects = getJSON('projects.php');


            $users[] = array("username"=>$username,"password"=>$password,"project"=>$username);
            saveJSON('users.php',$users);

		$projects[] = array("name"=>$username,"path"=>$username);
		saveJSON('projects.php',$projects);

		$usernameprojects = array();
		$usernameprojects[] = $username ; 
	        saveJSON($username . '_acl.php',$usernameprojects);


                if(!mkdir( './workspace/'. $username    , 0755, true)) {
			echo   "Unable to create" ;
			exit(0);
                }
                

		echo   "繝ｦ繝ｼ繧ｶ ". $username ." 繧剃ｽ懈・縺励∪縺励◆" ;
	}

?>


<hr>

<a href="/"> top  </a>

</font>
</html>
