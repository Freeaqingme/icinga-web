<?php
// Connection Component Binding

/**
 * BaseIcingaContactgroupMembers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $contactgroup_member_id
 * @property integer $instance_id
 * @property integer $contactgroup_id
 * @property integer $contact_object_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIcingaContactgroupMembers extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $prefix = Doctrine_Manager::getInstance()->getConnectionForComponent("IcingaContactgroupMembers")->getPrefix();
        $this->setTableName($prefix.'contactgroup_members');
        $this->hasColumn('contactgroup_member_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
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
        $this->hasColumn('contactgroup_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('contact_object_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
	$this->hasOne('IcingaInstances as instance', array(
		'local' => 'instance_id',
		'foreign' => 'instance_id'			
	));
	
        parent::setUp();
        
    }
}