<?php

/**
 * BaseIcingaServices
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $service_id
 * @property integer $instance_id
 * @property integer $config_type
 * @property integer $host_object_id
 * @property integer $service_object_id
 * @property string $display_name
 * @property integer $check_command_object_id
 * @property string $check_command_args
 * @property integer $eventhandler_command_object_id
 * @property string $eventhandler_command_args
 * @property integer $notification_timeperiod_object_id
 * @property integer $check_timeperiod_object_id
 * @property string $failure_prediction_options
 * @property float $check_interval
 * @property float $retry_interval
 * @property integer $max_check_attempts
 * @property float $first_notification_delay
 * @property float $notification_interval
 * @property integer $notify_on_warning
 * @property integer $notify_on_unknown
 * @property integer $notify_on_critical
 * @property integer $notify_on_recovery
 * @property integer $notify_on_flapping
 * @property integer $notify_on_downtime
 * @property integer $stalk_on_ok
 * @property integer $stalk_on_warning
 * @property integer $stalk_on_unknown
 * @property integer $stalk_on_critical
 * @property integer $is_volatile
 * @property integer $flap_detection_enabled
 * @property integer $flap_detection_on_ok
 * @property integer $flap_detection_on_warning
 * @property integer $flap_detection_on_unknown
 * @property integer $flap_detection_on_critical
 * @property float $low_flap_threshold
 * @property float $high_flap_threshold
 * @property integer $process_performance_data
 * @property integer $freshness_checks_enabled
 * @property integer $freshness_threshold
 * @property integer $passive_checks_enabled
 * @property integer $event_handler_enabled
 * @property integer $active_checks_enabled
 * @property integer $retain_status_information
 * @property integer $retain_nonstatus_information
 * @property integer $notifications_enabled
 * @property integer $obsess_over_service
 * @property integer $failure_prediction_enabled
 * @property string $notes
 * @property string $notes_url
 * @property string $action_url
 * @property string $icon_image
 * @property string $icon_image_alt
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIcingaServices extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $prefix = Doctrine_Manager::getInstance()->getConnectionForComponent("IcingaServices")->getPrefix();
        $this->setTableName($prefix.'services');
        $this->hasColumn('service_id', 'integer', 4, array(
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
        $this->hasColumn('host_object_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('service_object_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('display_name', 'string', 64, array(
             'type' => 'string',
             'length' => 64,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('check_command_object_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('check_command_args', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('eventhandler_command_object_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('eventhandler_command_args', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notification_timeperiod_object_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('check_timeperiod_object_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('failure_prediction_options', 'string', 64, array(
             'type' => 'string',
             'length' => 64,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('check_interval', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('retry_interval', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('max_check_attempts', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('first_notification_delay', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notification_interval', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notify_on_warning', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notify_on_unknown', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notify_on_critical', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notify_on_recovery', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notify_on_flapping', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notify_on_downtime', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('stalk_on_ok', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('stalk_on_warning', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('stalk_on_unknown', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('stalk_on_critical', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('is_volatile', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('flap_detection_enabled', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('flap_detection_on_ok', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('flap_detection_on_warning', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('flap_detection_on_unknown', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('flap_detection_on_critical', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('low_flap_threshold', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('high_flap_threshold', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('process_performance_data', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('freshness_checks_enabled', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('freshness_threshold', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('passive_checks_enabled', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('event_handler_enabled', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('active_checks_enabled', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('retain_status_information', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('retain_nonstatus_information', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notifications_enabled', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('obsess_over_service', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('failure_prediction_enabled', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notes', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('notes_url', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('action_url', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('icon_image', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('icon_image_alt', 'string', 255, array(
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
        parent::setUp();

	$this->hasOne("IcingaHosts as host",array(
	    'local' => 'host_object_id',
	    'foreign' => 'host_object_id'
	));
	$this->hasOne("IcingaInstances as instance", array(
	    'local' => 'instance_id',
	    'foreign' => 'instance_id'
	));
	$this->hasMany("IcingaComments as comments", array(
	    'local' => 'service_object_id',
	    'foreign' => 'object_id'
	));
    $this->hasMany("IcingaCommenthistory as commenthistory", array(
	    'local' => 'service_object_id',
	    'foreign' => 'object_id'
	));
	$this->hasOne("IcingaServicestatus as status", array(
	    'local' => 'service_object_id',
	    'foreign' => 'service_object_id'
	));
	$this->hasMany("IcingaServicechecks as checks", array(
	    'local' => 'service_object_id',
	    'foreign' => 'service_object_id'
	));
	///Retrieved by custom finder 
	$this->hasMany("IcingaContacts as contacts", array(
	    'local' => 'service_id',
	    'foreign' => 'contact_object_id'
	   // 'refclass' => 'IcingaServiceContacts'
	));
	$this->hasMany("IcingaContactgroups as contactgroups", array(
	    'local' => 'service_id',
	    'foreign' => 'contactgroup_object_id'
	 //   'refclass' => 'IcingaServiceContactgroups'
	));
	$this->hasOne("IcingaCommands as checkCommand", array(
	    'local' => 'check_command_object_id',
	    'foreign' => 'object_id'
	));
	$this->hasOne("IcingaCommands as eventHandlerCommand", array(
	    'local' => 'eventhandler_command_object_id',
	    'foreign' => 'object_id'
	));
	$this->hasMany("IcingaStatehistory as history", array(
	    'local' => 'service_object_id',
	    'foreign' => 'object_id'
	));
	$this->hasMany("IcingaServiceescalations as escalations", array(
	    'local' => 'service_object_id',
	    'foreign' => 'service_object_id'
	));
	$this->hasMany("IcingaTimedevents as timedevents", array(
	    'local' => 'service_object_id',
	    'foreign' => 'object_id'
	));
	$this->hasMany("IcingaScheduleddowntime as scheduledDowntimes", array(
	    'local' => 'service_object_id',
	    'foreign' => 'object_id'
	));
	$this->hasMany("IcingaDowntimehistory as downtimeHistory", array(
	    'local' => 'service_object_id',
	    'foreign' => 'object_id'
	));
	$this->hasMany("IcingaCustomvariables as customvariables", array(
	    'local' => 'service_object_id',
	    'foreign' => 'object_id'
	));
	$this->hasMany("IcingaServices as dependencies", array(
	    'local' => 'service_object_id',
	    'foreign' => 'dependent_service_object_id',
	    'refClass' => 'IcingaServicedependencies'
	));
	$this->hasMany("IcingaServicegroups as servicegroups", array(
	    'local' => 'service_object_id',
	    'foreign' => 'servicegroup_id',
	    'refClass' => 'IcingaServicegroupMembers'
	));
	$this->hasMany("IcingaNotifications as notification", array(
	    'local' => 'service_object_id',
	    'foreign' => 'object_id'
	));
	$this->hasMany("IcingaAcknowledgements as acknowledgements", array(
	    'local' => 'service_object_id',
	    'foreign' => 'object_id'
	));

	$this->hasOne("IcingaTimeperiods as notificationTimeperiod", array(
    	    'local' => 'notification_timeperiod_object_id',
    	    'foreign' => 'timeperiod_object_id',
	));	
	$this->hasOne("IcingaTimeperiods as checkTimeperiod", array(
    	    'local' => 'check_timeperiod_object_id',
    	    'foreign' => 'timeperiod_object_id',
	));
    }
}
