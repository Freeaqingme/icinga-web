<?php
// Connection Component Binding

/**
 * BaseIcingaContactAddresses
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $contact_address_id
 * @property integer $instance_id
 * @property integer $contact_id
 * @property integer $address_number
 * @property string $address
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIcingaContactAddresses extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $prefix = Doctrine_Manager::getInstance()->getConnectionForComponent("IcingaContactAddresses")->getPrefix();
        $this->setTableName($prefix.'contact_addresses');
        $this->hasColumn('contact_address_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('instance_id', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('contact_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('address_number', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('address', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
 	$this->hasOne('IcingaInstance as instance', array(
		'local' => 'instance_id',
		'foreign' => 'instance_id'			
	));
	$this->hasOne('IcingaContacts as contact', array(
		'local' => 'contact_id',
		'foreign' => 'contact_id'			
	));
	
	parent::setUp();
        
    }
}
