<?php

class AppKit_SquishFileContainerModel extends AppKitBaseModel
{
	const TYPE_JAVASCRIPT	= 'js';
	const TYPE_STYLESHEET	= 'css';
	
	private $files			= array();
	private $actions		= array();
	private $type			= null;
	private $content		= null;
    private $checksum       = null;	
	private $maxCacheTime   = 14400;
    private $useCaching     = false;
    private $cache_dir      = null;
    /**
	 * (non-PHPdoc)
	 * @see lib/agavi/src/model/AgaviModel#initialize($context, $parameters)
	 */
	public function initialize(AgaviContext $context, array $parameters = array()) {
		
		if (array_key_exists('type', $parameters)) {
			$this->setType($parameters['type']);
		}
		
		parent::initialize($context, $parameters);
        $cfg = AgaviConfig::get('modules.appkit.squishloader');
        if(isset($cfg['use_caching']))
	        $this->useCaching = $cfg['use_caching'];
    
        if(isset($cfg['cache_dir']))
	        $this->cache_dir = $cfg['cache_dir'];
 
        if(!$this->cache_dir)
            $this->useCaching = false;
    }
	
	/**
	 * Adding a single file
	 * @param $file
	 * @param $type
	 * @return unknown_type
	 */
	public function addFile($file) {
		if (file_exists($file)) {
			$this->files[] = $file;
			return true;
		}
		
		throw new AppKitModelException('File not found: '. $file);
	}
	
	/**
	 * Adding an array of files
	 * @param array $files
	 * @param $type
	 * @return unknown_type
	 */
	public function addFiles(array $files) {
		$this->files = $files + $this->files; 
		return true;
	}
	
	/**
	 * Sets agavi actions
	 * @param array $actions
	 * @return unknown_type
	 */
	public function setActions(array $actions) {
		$this->actions = ($actions) + $this->actions;
		return true;
	}
	
	private function setType($type) {
		$this->type = $type;
		return true;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function squishContents($lastSquish = null) {
	    if($lastSquish) {
            $this->getCachedChecksum();
            if($lastSquish == $this->checksum)
                return true;
        }
		$this->content = null;
		
		if (is_array($this->files)) {
		    if($this->useCaching)
                $this->readCached();
            if($this->content)
                return false;
            
            $loader = $this->getContext()->getModel('BulkLoader', 'AppKit', array(
				'newlines' => false,
				'indent' => false,
				'comments' => false
			));
		    
			$loader->setFiles($this->files);			
			$this->content = $loader->getContent();
            $this->checksum = md5($this->content);
		    if($this->useCaching)
                $this->cacheContent();
        }
	
		return $lastSquish && $lastSquish == $this->checksum;
	}
	
    private function getCacheFilename() {
        $file = "squish_".md5(implode(";",$this->files));
         
        $cached = $this->cache_dir.'/'.$file;
        if(!file_exists($this->cache_dir))
            AgaviToolkit::mkdir($this->cache_dir);        
        return $cached;
    }

    private function readCached() {
        $cached = $this->getCacheFilename();
        
        if(file_exists($cached)  && is_readable($cached)) {
            // check cache date
            if(time()-filemtime($cached) > $this->maxCacheTime)
                return null;
            $this->content = file_get_contents($cached);
            // If checksum is not already loaded, do it now
            if(!$this->checksum)
                $this->getCachedChecksum();
            if(!$this->checksum) // if checksum can't be loaded from cache calculate it
                $this->checksum = md5($this->content);
        }
        return null;
    }

    private function getCachedChecksum() {
        $cached = $this->getCacheFilename().".sum";
 
        if(is_readable($cached) && file_exists($cached)) { 
            if(time()-filemtime($cached) > $this->maxCacheTime)
                return null;
            
            $this->checksum = file_get_contents($cached);
        }
        return null;
    }

    private function cacheContent() {
        $cached = $this->getCacheFilename();
        $cacheDir = dirname($cached);
      
        if(file_exists($cached) && !is_writeable($cached))
            return;
        if(!is_dir($cacheDir) || !is_writeable($cacheDir))
            return;
        file_put_contents($cached,$this->content);
        file_put_contents($cached.".sum",$this->checksum);

    }

	public function getContent() {
		return $this->content;
	}
    public function getChecksum() {
        return $this->checksum;
    }
    	
	public function getActions() {
		return $this->actions;
	}
}