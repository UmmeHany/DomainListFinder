<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DomainInfo extends AbstractController {

	private  $domainName;
	private  $registrationDate;
	private  $expirationDate;
	private  $domainStatus;
	private  $registrantID;
	
	public function getDomainName() {
		return $this->domainName;
	}
	
	public function setDomainName($domain_Name) {
		$this->domainName = $domain_Name;
	}

	public function getRegistrationDate() {
		return $this->registrationDate;
	}

	public function setRegistrationDate($registration_Date) {
		$this->registrationDate = $registration_Date;
	}

	public function getExpirationDate() {
		return $this->expirationDate;
	}

	public function setExpirationDate($expiration_Date) {
		$this->expirationDate = $expiration_Date;
	}

	public function getDomainStatus() {
		return $this->domainStatus;
	}

	public function setDomainStatus($domain_Status) {
		$this->domainStatus = $domain_Status;
	}

	public function getRegistrantID() {
		return $this->registrantID;
	}

	public function setRegistrantID($registrant_ID) {
		$this->registrantID = $registrant_ID;
	}
	


}
