<?php
/**
 * BaseIcingaServiceescalationContacts
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $serviceescalation_contact_id
 * @property integer $instance_id
 * @property integer $serviceescalation_id
 * @property integer $contact_object_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIcingaServiceescalationContacts extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $prefix = Doctrine_Manager::getInstance()->getConnectionForComponent("IcingaServiceescalationContacts")->getPrefix();
        $this->setTableName($prefix.'serviceescalation_contacts');
        $this->hasColumn('serviceescalation_contact_id', 'integer', 4, array(
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
        $this->hasColumn('serviceescalation_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('contact_object_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}