<?php
// Connection Component Binding


/**
 * BaseIcingaCommands
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property integer $command_id
 * @property integer $instance_id
 * @property integer $config_type
 * @property integer $object_id
 * @property string $command_line
 *
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIcingaCommands extends Doctrine_Record {
    public function setTableDefinition() {
        $prefix = Doctrine_Manager::getInstance()->getConnectionForComponent("IcingaCommands")->getPrefix();
        $this->setTableName($prefix.'commands');
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
        $this->hasColumn('command_line', 'string', 1024, array(
                             'type' => 'string',
                             'length' => 1024,
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
        $this->hasOne('IcingaObjects as object', array(
            'local' => 'object_id',
            'foreign' => 'id'
        ));
        parent::setUp();

    }
}
