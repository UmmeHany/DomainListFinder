<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\SessionBasedCom;

class APIController extends AbstractController {
   		
    /**
-      * @Route("/login")
-      * @Method({"GET"})
    */
    public function index() {
    $check =0; 
    return $this->render('API/login.html.twig',array('check' => $check));  
    } 

    /**
       * @Route("/login_check", name="login_check", methods={"POST"})
    */
    public function login(Request $request){
    	$username = $request->request->get('_username');
    	$password = $request->request->get('_password');
    	$dminfo = new SessionBasedCom();
    	$response=$this->forward('App\Controller\SessionBasedCom::setcredentials', array(
    	'username'  => $username,
        'password' => $password
    	));
    	$dminfo->apicall();
    	$p=$dminfo->getDomainList();

    	if($dminfo->getSessionId() !=""){
    		return $this->render('API/result.html.twig',array('domain_list' => $p,'session_id' => $dminfo->getSessionId(),'username' => $username));
    	}
    	else{
    		$check=-1;
    		return $this->render('API/login.html.twig',array('check' => $check));
    	}
    }

    /**
       * @Route("/logout", name="logout", methods={"POST"})
    */
    public function logout() {
    
    	$scom = new SessionBasedCom();
    	$response=$scom->logout();
    	if($response = "LOGOUT SUCCEEDED"){
    		$check =0; 
    		return $this->render('API/login.html.twig',array('check' => $check));
    	}
    	
    } 

    


    
}

?>