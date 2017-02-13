<?php 
/**
 * 
 */
 class ClassName extends AnotherClass
 {
 	
 	public function __construct()
	{
		# code...
	}

	public function getName($id)
	{
		return 'sam';
	}


}
$params= array('uri'=>'http://localhost/test/server.php');
$Server = new SoapServer(null,$params);
$server->setClass('server');
$server->hendle();
 ?>