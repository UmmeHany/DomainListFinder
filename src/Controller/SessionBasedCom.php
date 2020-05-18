<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use vendor\HEXONET\APIClient;
use App\Controller\DomainInfo;

class SessionBasedCom extends AbstractController {

	private $user_name;
	private $pass_word;
	private $cl;
	private $domainList;
	private $my_session_id;

	public function __construct(){
		$this->cl =new \HEXONET\APIClient();
	}
  
	public function setcredentials($username,$password) {
	    $this->username = $username;
	    $this->password = $password;
	    global $user_name, $pass_word;
	    $user_name = $this->username;
	    $pass_word = $this->password;
	    return new Response('credentials set');
  }

  public function getUserName(){
  	 return $this->user_name;
  }

  	public function apicall(){
  		global $user_name, $pass_word;

		$this->cl->useOTESystem()//LIVE System would be used otherwise by default
		   ->setCredentials($user_name,$pass_word);//test.user,test.passw0rd
		$r = $this->cl->login();

		if ($r->isSuccess()){

		    $this->cl->saveSession($_SESSION);
			$this->my_session_id = $this->cl->getSession();

		    $r = $this->cl->request(array(
		        "COMMAND" => "QueryDomainList",
		        "USERDEPTH" => "SELF",
		        "WIDE" => "1",
		        "FIRST" => "0",
		        "LIMIT" => "50"
		    ));
		    
		    $this->domainList = array();
		    
		    $c=$r->getRecordsCount();
			for ($i=0;$i<$c;$i++) {

				$domm = new DomainInfo();

				$domainName= $r->getRecord($i)->getDataByKey("DOMAIN");
				$domm->setDomainName($domainName);

				$registrationDate= $r->getRecord($i)->getDataByKey("DOMAINCREATEDDATE");
				$domm->setRegistrationDate($registrationDate);

				$expirationDate= $r->getRecord($i)->getDataByKey("DOMAINEXPIRATIONDATE");
				$domm->setExpirationDate($expirationDate);

				$domainStatus= $r->getRecord($i)->getDataByKey("DOMAINSTATUS");
				$domm->setDomainStatus($domainStatus);

				$registrantID= $r->getRecord($i)->getDataByKey("DOMAINOWNERCONTACT");
				$domm->setRegistrantID($registrantID);
				array_push($this->domainList,$domm);

			}
			
		    	return new Response("command_executed_success");
		}
		else {
		    	return new Response('LOGIN Failed');
		}
  	} 

  	public function logout(){
  		// Perform session close and logout
		    $r = $this->cl->logout();
		    if ($r->isSuccess()){
		    	return new Response('LOGOUT SUCCEEDED');
		    } else {
		    	return new Response('LOGOUT Failed');
		    }
  	}

  	public function getDomainList() {
  			return $this->domainList;
  	}
  	public function getSessionId() {
  			return $this->my_session_id;
  	}



}

?>

