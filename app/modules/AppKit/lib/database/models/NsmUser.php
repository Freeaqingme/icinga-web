<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NsmUser extends BaseNsmUser {

    const HASH_ALGO = 'sha256';

    private static $prefCache = array();
    
    /**
     * Reduce database query overhead
     * @var array
     */
    private static $targetValuesCache = array();

    /**
     * @var Doctrine_Collection
     */
    private $principals			= null;

    /**
     * @var array
     */
    private $principals_list	= null;
    
    private $context = null;
    
    private $storage = null;
    
    /**
     * (non-PHPdoc)
     * @see lib/appkit/database/models/generated/BaseNsmUser#setTableDefinition()
     */
    public function setTableDefinition() {

        parent::setTableDefinition();

        $this->index('user_name_unique', array(
                         'fields' => array(
                             'user_name'
                         ),
                         'type' => 'unique'
        ));

           // Removed by #2228
//         $this->index('user_email_unique', array(
//                          'fields' => array(
//                              'user_email'
//                           ),
//                           'type' => 'unique'
//         ));
        
        $this->index('user_search', array(
                         'fields' => array(
                             'user_name',
                             'user_authsrc',
                             'user_authid',
                             'user_disabled'
                         )
        ));
    }

    public function getContext() {
        if(!$this->context)
            $this->context = AgaviContext::getInstance();
        return $this->context;
    }

    public function getStorage() {
        if(!$this->storage)
            $this->storage = $this->getContext()->getStorage();
        return $this->storage;
    }

    public function setUp() {
        
        parent::setUp();

        $this->hasMany('NsmRole', array('local'		=> 'usro_user_id',
                                        'foreign'	=> 'usro_role_id',
                                        'refClass'	=> 'NsmUserRole'));

        $options = array(
                       'created' =>  array('name'	=> 'user_created'),
                       'updated' =>  array('name'	=> 'user_modified'),
                   );

        $this->actAs('Timestampable', $options);

    }

    public function givenName() {
        if ($this->user_lastname && $this->user_firstname) {
            return sprintf('%s, %s', $this->user_lastname, $this->user_firstname);
        } else {
            return $this->user_name;
        }
    }

    public function hasRoleAssigned($role_id) {
        foreach($this->NsmRole as $role) {
            if ($role_id == $role->role_id) {
                return true;
            }
        }

        return false;
    }

    private function __updatePassword($password) {
        $this->user_salt = $this->__createSalt($this->user_name);
        hash_hmac(self::HASH_ALGO, $password, $this->user_salt);
        $this->user_password = hash_hmac(self::HASH_ALGO, $password, $this->user_salt);
    }

    private function __createSalt($entropy) {
        return hash(self::HASH_ALGO, uniqid($entropy. '_', mt_rand()));
    }

    public function updatePassword($password) {
        if ($this->state() !== self::STATE_TDIRTY) {
            $this->__updatePassword($password);
        } else {
            throw new AppKitDoctrineException('Could not change a password on a not existing record!');
        }

        return false;
    }
    
    /**
     * Sets a random password for the user
     * @return null really nothing
     * @param integer $length
     */
    public function generateRandomPassword($length=10) {
        $password = AppKitRandomUtil::genSimpleId($length, microtime(true));
        $this->__updatePassword($password);
    }

    /**
     * Sets a pref value
     * @param string $key
     * @param mixed $val
     * @param boolean $overwrite
     * @param boolean $blob
     * @return unknown_type
     * @throws AppKitException
     * @author Marius Hein
     */
    public function setPref($key, $val, $overwrite = true, $blob = false) {

        try {
            $pref = $this->getPrefObject($key);

            // DO NOT OVERWRITE
            if ($overwrite === false) {
                return false;
            }

            if ($blob == true) {
                $pref->upref_longval = $val;
            } else {
                $pref->upref_val = $val;
            }

            $pref->save();
        } catch (AppKitDoctrineException $e) {
            $pref = new NsmUserPreference();
            $pref->upref_key = $key;

            if ($blob == true) {
                $pref->upref_longval = $val;
            } else {
                $pref->upref_val = $val;
            }

            $pref->NsmUser = $this;
            $pref->save();
        }

        return true;
    }

    /**
     * Returns a preferenceobject from a user
     * @param string $key
     * @return NsmUserPreference
     * @throws AppKitDoctrineException
     * @author Marius Hein
     */
    public function getPrefObject($key) {
        $res = AppKitDoctrineUtil::createQuery()
               ->from('NsmUserPreference p')
               ->where('p.upref_user_id=? and p.upref_key=?', array($this->user_id, $key))
               ->limit(1)
               ->execute();

        if ($res->count() == 1 && ($obj = $res->getFirst()) instanceof NsmUserPreference) {

            //var_dump($res->toArray(true));

            return $obj;
        }

        throw new AppKitDoctrineException('Preference record not found!');
    }

    /**
     * Returns the real value of a preference
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @author Marius Hein
     */
    public function getPrefVal($key, $default=null, $blob = false) {
        try {
            $obj = $this->getPrefObject($key,$noThrow = false);

            if ($obj->upref_longval || $blob) {
                return $obj->upref_longval;
            } else {
                return $obj->upref_val;
            }
        } catch (AppKitDoctrineException $e) {
            return $default;
        }
    }

    /**
     * Returns the authid to identify the user against the provider
     * @return string
     */
    public function getAuthId() {
        if ($this->user_authid) {
            return $this->user_authid;
        }

        return $this->user_name;
    }

    public function getPrefComponent($key, $component_name) {
        $val = $this->getPrefVal($key);

        if ($val) {
            return Doctrine::getTable($component_name)->find($val);
        }

        return null;
    }

    /**
     * Deletes a pref value from the user
     * @param string $key
     * @return boolean if something was deleted
     * @author Marius Hein
     */
    public function delPref($key) {
        /*
         * WORKAROUND:
         * Postgresql doesn't support limit, so we must first select a row, then delete it
         */
        $idToDelete = AppKitDoctrineUtil::createQuery()
                      ->select("upref_id")
                      ->from("NsmUserPreference p")
                      ->where('p.upref_user_id=? and p.upref_key=?', array($this->user_id, $key))
                      ->execute()->getFirst();

        if (is_null($idToDelete)) {
            return false;
        }

        $upref_id = $idToDelete->get('upref_id');
        $test = AppKitDoctrineUtil::createQuery()
                ->delete('NsmUserPreference p')
                ->where('p.upref_id=? and p.upref_user_id=? and p.upref_key=?', array($upref_id,$this->user_id, $key))
                //->limit(1)  -> not supported by postgresql
                ->execute();

        if ($test) {
            return true;
        } else {
            return false;
        }
    }

    public function getPreferences() {
        $res = AppKitDoctrineUtil::createQuery()
               ->select('p.upref_val, p.upref_key, p.upref_longval')
               ->from('NsmUserPreference p INDEXBY p.upref_key')
               ->where('p.upref_user_id=?', array($this->user_id))
               ->execute(array(), Doctrine::HYDRATE_ARRAY);

        $out = array();
        foreach($res as $key=>$d) $out[$key] = $d['upref_longval'] ? 'BLOB' : $d['upref_val'];

        // Adding defaults
        foreach(AgaviConfig::get('modules.appkit.user_preferences_default', array()) as $k=>$v) {
            if (!array_key_exists($k, $out)) {
                $out[$k] = $v;
            }
        }

        return $out;
    }

    public function getPreferencesList(array $list=array()) {
        $res = AppKitDoctrineUtil::createQuery()
               ->select('p.upref_val, p.upref_key')
               ->from('NsmUserPreference p INDEXBY p.upref_key')
               ->where('p.upref_user_id=?', array($this->user_id))
               ->andWhereIn('p.upref_key', $list)
               ->execute(array(), Doctrine::HYDRATE_ARRAY);

        $out = array();
        foreach($res as $key=>$d) $out[$key] = $d['upref_val'];

        return $out;
    }

    /**
     * Returns the status of the corresponding principal
     * @return boolean
     */
    public function principalIsValid() {
        return ($this->NsmPrincipal->principal_id > 0 && $this->NsmPrincipal->principal_type == 'user') ? true : false;
    }

    /**
     * Returns a list of all belonging principals
     * @return array
     */
    public function getPrincipalsList() {

        if ($this->principals_list === null) {

            $this->principals_list = array_keys($this->getPrincipals()->toArray());

        }

        return $this->principals_list;
    }

    public function getUserPrincipalsList() {
        return array_keys(AppKitDoctrineUtil::createQuery()
            ->select('p.*')
            ->from('NsmPrincipal p INDEXBY p.principal_id')
            ->orWhere('p.principal_user_id = ?',$this->user_id)
            ->execute()->toArray());
    }
    
    private function collectChildRoleIdentifier(NsmRole $role, array &$store = array ()) {
            foreach ($role->getChildren() as $child) {
                $this->collectChildRoleIdentifier($child, $store);
                $store[] = $child->role_id;
            }
    }

    private function getRoleIds() {
        
        $use_topdown = AgaviConfig::get('modules.appkit.auth.behaviour.group_topdown');
        
        $ids = array();
        foreach($this->NsmRole as $role) {
            if($role->role_disabled)
                continue;
            $ids[] = $role->role_id;
            
            /*
             * This is devel classic behaviour. Inheritance
             * of roles goes top-down. This means the role with all
             * credentials is the deepest.
             */
            if ($use_topdown === true) {
                while ($role->hasParent()){
                    $role = $role->parent;
                    if($role->role_disabled)
                        continue;
                    $ids[] = $role->role_id;       
                }
            
            /*
             * This is more group managing like. The group on top
             * collects all credentials from underlaying groups
             */
            } else {
                $this->collectChildRoleIdentifier($role, $ids);
            }
        }

        $ids = array_unique($ids);
        
        return $ids;
    }
    
    /**
     * Return all principals belonging to this
     * user
     * @return Doctrine_Collection
     */
    public function getPrincipals($userOnly= false) {

        if ($this->principals === null) {
            $roles = $this->getRoleIds();
            $this->principals = AppKitDoctrineUtil::createQuery()
                                ->select('p.*')
                                ->from('NsmPrincipal p INDEXBY p.principal_id')
                                ->andWhereIn('p.principal_role_id',$roles)

                                ->orWhere('p.principal_user_id = ?',$this->user_id)
                                ->execute();

        }
        
        return $this->principals;
    }

    public function getPrincipalsArray() {
        static $out = array();

        if (count($out) == 0) {
            foreach($this->getPrincipals() as $p) {
                $out[] = $p->principal_id;
            }
        }

        return $out;
    }

    /**
     * Return all targets belonging to thsi user
     * @param string $type
     * @return Doctrine_Collection
     */
    public function getTargets($type=null,$userOnly = false) {

        return $this->getTargetsQuery($type,$userOnly)->execute();
    }

    /**
     *
     * Returns a DQL providing the user targets
     * @param string $type
     * @return Doctrine_Query
     */
    protected function getTargetsQuery($type=null,$userOnly = false) {
        $principals = $userOnly ? $this->getUserPrincipalsList() : $this->getPrincipalsList();
        $q = AppKitDoctrineUtil::createQuery()
             ->select('t.*')
             ->distinct(true)
             ->from('NsmTarget t INDEXBY t.target_id')
             ->innerJoin('t.NsmPrincipalTarget pt')
             ->andWhereIn('pt.pt_principal_id', $principals);

        if ($type !== null) {
            $q->andWhere('t.target_type=?', array($type));
        }

        return $q;
    }

    /**
     * Returns true if a target exists
     * @param string $name
     * @return boolean
     */
    public function hasTarget($name) {
        $q = $this->getTargetsQuery();
        $q->andWhere('t.target_name=?', array($name));

        if ($q->execute()->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param string $name
     * @return NsmTarget
     */
    public function getTarget($name) {
        $col = Doctrine::getTable('NsmTarget')->findByDql('target_name=?', array($name));

        if ($col->count() == 1 && $this->hasTarget($name)) {
            return $col->getFirst();
        } else {
            return null;
        }
    }

    /**
     * Returns a query with all values to a target
     * @param string $name
     * @return Doctrine_Query
     */
    protected function getTargetValuesQuery($target_name) {
        $q = AppKitDoctrineUtil::createQuery()
             ->select('tv.*')
             ->from('NsmTargetValue tv')
             ->innerJoin('tv.NsmPrincipalTarget pt')
             ->innerJoin('pt.NsmTarget t with t.target_name=?', $target_name)
             ->andWhereIn('pt.pt_principal_id', $this->getPrincipalsList());
        return $q;
    }

    /**
     * Return all target values as Doctrine_Collection
     * @param string $target_name
     * @return Doctrine_Collection
     */
    public function getTargetValues($target_name) {
        $result =  $this->getTargetValuesQuery($target_name)->execute(); 
        
        return $result;
    }

    public function getTargetValue($target_name, $value_name) {
        $q = $this->getTargetValuesQuery($target_name);
        $q->select('tv.tv_val');
        $q->andWhere('tv.tv_key=?', array($value_name));
        $res = $q->execute();

        $out = array();
        foreach($res as $r) {
            $out[] = $r->tv_val;
        }

        return $targets;
    }

    public function getTargetValuesArray() {
        if (count(self::$targetValuesCache) == 0) {
            $tc = AppKitDoctrineUtil::createQuery()
                  ->select('t.target_name, t.target_id')
                  ->from('NsmTarget t')
                  ->innerJoin('t.NsmPrincipalTarget pt')
                  ->andWhereIn('pt.pt_principal_id', $this->getPrincipalsList())
                  ->execute();
    
            $out = array();
    
            foreach($tc as $t) {
                $out[ $t->target_name ] = array();
    
                $ptc = AppKitDoctrineUtil::createQuery()
                       ->from('NsmPrincipalTarget pt')
                       ->innerJoin('pt.NsmTargetValue tv')
                       ->andWhereIn('pt.pt_principal_id', $this->getPrincipalsList())
                       ->andWhere('pt.pt_target_id=?', array($t->target_id))
                       ->execute();
    
                foreach($ptc as $pt) {
                    $tmp = array();
                    foreach($pt->NsmTargetValue as $tv) {
                        $tmp[ $tv->tv_key ] = $tv->tv_val;
                    }
    
                    $out[ $t->target_name ][] = $tmp;
                }
                
                self::$targetValuesCache =& $out;
            }
        
        }
        return self::$targetValuesCache;
    }
}
