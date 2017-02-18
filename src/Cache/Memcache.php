<?php
    namespace Cheukpang\NotORM\Cache;
    
    use Cheukpang\NotORM\ICache;
    
    /**
     * Class NotORM_Cache_Memcache
     * Cache using "NotORM." prefix in Memcache
     * @package Cheukpang\NotORM\Cache
     */
    class Memcache implements ICache
    {
        private $memcache;
        
        public function __construct(\Memcache $memcache)
        {
            $this->memcache = $memcache;
        }
        
        public function load($key)
        {
            $return = $this->memcache->get('NotORM'.$key);
            if ($return === false) {
                return null;
            }
            
            return $return;
        }
        
        public function save($key, $data)
        {
            $this->memcache->set('NotORM'.$key, $data);
        }
        
    }
