<?php
/**
 * Api wrapping agavi model
 * 
 * Provides access to preconfigured IcingaApi 
 * 
 * @author mhein
 * @package icinga-web
 * @subpackage icinga
 */
class Web_Icinga_ApiContainerModel extends IcingaWebBaseModel
implements AgaviISingletonModel {

	/**
	 * Used namespaces to gather config from
	 * @var array
	 */
	private static $configMap = array (
		'modules.web.api.file'					=> 'apiFile',
		'modules.web.api.class'					=> 'apiClass',
		'modules.web.api.interfaces.data'		=> 'configData',
		'modules.web.api.interfaces.command'	=> 'configCmd'
	);
	
	/**
	 * File there the api resides
	 * @var string
	 */
	private $apiFile		= null;
	
	/**
	 * Class name 
	 * @var string
	 */
	private $apiClass		= null;
	
	/**
	 * Configuration of the connection
	 * @var array
	 */
	private $configData		= null;
	
	/**
	 * Configuration of command dispatchers
	 * @var array
	 */
	private $configCmd		= null;
	
	/**
	 * 
	 * @var IcingaApiConnection
	 */
	private $apiData		= null;
	
	/**
	 * Array of IcingaApiCommandDispatcher
	 * @var array
	 */
	private $apiDispatcher	= array ();
	
	/**
	 * (non-PHPdoc)
	 * @see lib/agavi/src/model/AgaviModel#initialize($context, $parameters)
	 */
	public function initialize(AgaviContext $c, array $p=array()) {
		parent::initialize($c, $p);
		
		// We need all settings from configuration here
		$this->mapConfig();
		
		// Notice about missing IcingaApi
		$this->checkClass();
		
		$this->initConnection();
		
		$this->initDispatcher();
	}
	
	/**
	 * Iterates through the dispatcher config space
	 * and creates dispatcher objects
	 * @return boolean
	 * @author mhein
	 */
	private function initDispatcher() {
		if (isset($this->configCmd) && is_array($this->configCmd)) {
			foreach ($this->configCmd as $key=>$interface) {
				if (array_key_exists('enabled', $interface) && $interface['enabled'] === true) {
					
					$config = $interface;
					unset($config['type']);
					unset($config['enabled']);
					
					$type = AppKit::getConstant($interface['type']);
					
					$this->apiDispatcher[$key] = IcingaApi::getCommandDispatcher();
					$this->apiDispatcher[$key]->setInterface($type, $config);
					
				}
			}
		}
		
		if (count($this->apiDispatcher)) {
			return true;
		}
		
		// Some notice
		// AgaviContext::getInstance()->getLoggerManager()->logWarning('No command dispatcher configured!');
		// throw new AppKitFactoryException('No command dispatcher was configured');
	}
	
	/**
	 * Initiates the IcingaApiConnection
	 * @return boolean
	 * @throws IcingaApiException
	 * @author mhein
	 */
	private function initConnection() {
		$c = $this->configData;
		
		$type = AppKit::getConstant($c['api_type']);
		// if (!$type) throw new AppKitModelException('Could not get api_type \'%s\' for connection', $c['api_type']);
		
		$capi = array ();
		foreach ($c as $ckey=>$cdata) {
			if (strpos($ckey, 'config_') === 0) {
				$capi[ substr($ckey, 7) ] = $cdata;
			}
		}
		
		$this->apiData = IcingaApi::getConnection($type, $capi);
		
		return true;
	}
	
	/**
	 * Maps module config to our private class vars
	 * @throws AppKitModelException
	 * @return boolean
	 * @author mhein
	 */
	private function mapConfig() {
		foreach (self::$configMap as $setting=>$varname) {
			if (AgaviConfig::has($setting)) {
				$this->{ $varname } = AgaviConfig::get($setting, null);
			}
			else {
				throw new AppKitModelException('IcingaApi setting \'%s\' not configured', $setting);
			}
		}
		
		return true;
	}
	
	/**
	 * Check the IcingaApi class, includes
	 * the file also
	 * @return boolean
	 * @throws AppKitModelException
	 * @author mhein
	 */
	private function checkClass() {
		if (class_exists($this->apiClass)) {
			return true;
		}
		
		if (file_exists($this->apiFile)) {
			require_once($this->apiFile);
			return true;
		}
		
		throw new AppKitModelException(
			'ApiContainer failed to include class %s in \'%s\'',
			$this->apiClass,
			$this->apiFile
		);
		
	}
	
	/**
	 * Returns the initiated ApiConnecton
	 * @return IcingaApiConnection
	 * @author mhein
	 */
	public function getConnection() {
		return $this->apiData;
	}
	
	/**
	 * Same as getConnection, old style
	 * @see Web_Icinga_ApiContainerModel::getConnection()
	 * @return IcingaApiConnection
	 * @author mhein
	 */
	public function API() {
		return $this->getConnection();
	}
	
	/**
	 * Abstracts the API->getConnection(...)->createSearch(ICINGA::...)
	 * to a api bound method
	 * @return IcingaApiSearch
	 * @author mhein
	 */
	public function createSearch() {
		$a = func_get_args();
		$ref = new ReflectionObject($this->getConnection());
		if ($ref->hasMethod('createSearch')) {
			$m = $ref->getMethod('createSearch');
			return $m->invokeArgs($this->getConnection(), $a);
		}
		
		throw new IcingaApiException("Could not create search (method not found)");
	}
	
	/**
	 * Checks if command dispatcher exists
	 * @return boolean
	 * @author mhein
	 */
	public function checkDispatcher() {
		return (count($this->apiDispatcher) > 0) ? true : false;
	}
	
	/**
	 * Sends a single IcingaApi command definition
	 * @param IcingaApiCommand $cmd
	 * @return boolean
	 * @author mhein
	 */
	public function dispatchCommand(IcingaApiCommand &$cmd) {
		return $this->dispatchCommandArray(array($cmd));
	}
	
	/**
	 * Same as ::dispatchCommand(). Sends an array
	 * of command definitions
	 * @see Web_Icinga_ApiContainerModel::getConnection()
	 * @param array $arry
	 * @return unknown_type
	 * @author mhein
	 */
	public function dispatchCommandArray(array $arry) {
		$error = false;
		
		foreach ($this->apiDispatcher as $d) {
			
			try {
				$d->setCommand($arry);
				$d->send();
			}
			catch (IcingaApiCommandSendException $e) {
				$this->errors[] = $e;
				$error = true;
				
				AgaviContext::getInstance()->getLoggerManager()
				->logError('Command dispatch failed: '.  str_replace("\n", " ", print_r($d->getCallStack(), true)) );
			}
			
			// Reset into ready-state
			$d->clearCommands();
		}
		
		if ($error === true) {
			throw new IcingaCommandException('Errors occured try getLastError to fetch a exception stack!');
		}
		
		return true;
		
	}
	
}

?>