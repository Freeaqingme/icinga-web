<?php

/**
 * BaseIcingaCustomvariables
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property integer $customvariable_id
 * @property integer $instance_id
 * @property integer $object_id
 * @property integer $config_type
 * @property integer $has_been_modified
 * @property string $varname
 * @property string $varvalue
 *
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIcingaCustomvariables extends Doctrine_Record {
    public function setTableDefinition() {
        $prefix = Doctrine_Manager::getInstance()->getConnectionForComponent("IcingaCustomvariables")->getPrefix();
        $this->setTableName($prefix.'customvariables');
        $this->hasColumn('id', 'integer', 4, array(
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
        $this->hasColumn('object_id', 'integer', 4, array(
                             'type' => 'integer',
                             'length' => 4,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'default' => '0',
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('config_type', 'integer', 2, array(
                             'type' => 'integer',
                             'length' => 2,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'default' => '0',
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('has_been_modified', 'integer', 2, array(
                             'type' => 'integer',
                             'length' => 2,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'default' => '0',
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('varname', 'string', 255, array(
                             'type' => 'string',
                             'length' => 255,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'default' => '',
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('varvalue', 'string', 255, array(
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

    public function setUp() {
        $this->hasOne('IcingaInstances as instance', array(
                          'local' => 'instance_id',
                          'foreign' => 'id'
                      ));
        $this->hasMany('IcingaHosts as hosts', array(
                           'local' => 'object_id',
                           'foreign' => 'host_object_id'
                       ));
        $this->hasMany('IcingaHostgroups as hostgroups', array(
                           'local' => 'object_id',
                           'foreign' => 'hostgroup_object_id'
                       ));
        $this->hasMany('IcingaServices as services', array(
                           'local' => 'object_id',
                           'foreign' => 'service_object_id'
                       ));
        $this->hasMany('IcingaServicegroups as servicegroups', array(
                           'local' => 'object_id',
                           'foreign' => 'servicegroup_object_id'
                       ));
        $this->hasMany('IcingaContactgroups as contactgroups', array(
                           'local' => 'object_id',
                           'foreign' => 'contactgroup_object_id'
                       ));
        $this->hasMany('IcingaContacts as contact', array(
                           'local' => 'object_id',
                           'foreign' => 'contact_object_id'
                       ));
        $this->hasOne('IcingaObjects as object', array(
            'local' => 'object_id',
            'foreign' => 'id'
        ));
        parent::setUp();

    }
}
