<?php

/**
 * IcingaServices
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class IcingaServices extends BaseIcingaServices
{
	public static $STATE_OK = 0;
	public static $STATE_WARNING = 1;
	public static $STATE_CRITICAL = 2;
	public static $STATE_UNKNOWN = 3;

	public function __get($method)  {

		switch($method) {
			case  'contacts':
				$contacts = $this->getContacts();					
				$this->set("contacts",$contacts);
				return $contacts;
				break;
			case 'contactgroups':
				$contactgroups = $this->getContactgroups();
				$this->set("contactgroups",$contactgroups);
				return $contactgroups;
				break;
		}
		return parent::__get($method);
	} 	
	public function getContacts() {
		return Doctrine_Query::create()
			->select("c.*")
			->from("IcingaContacts c")
			->innerJoin("c.services hc ON hc.service_id = ".$this->service_id
				." AND hc.instance_id = ".$this->instance_id." AND hc.contact_object_id = c.contact_object_id")
			->execute(null,Doctrine_Core::HYDRATE_RECORD);
		
	}
	
	public function getContactgroups() {
		return Doctrine_Query::create()
			->select("c.*")
			->from("IcingaContactgroups c")
			->innerJoin("c.services hc ON hc.service_id = ".$this->service_id
				." AND hc.instance_id = ".$this->instance_id." AND hc.contactgroup_object_id = c.contactgroup_object_id")
			->execute(null,Doctrine_Core::HYDRATE_RECORD);	
	}	
	
}
