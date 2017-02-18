<?php
    namespace Cheukpang\NotORM\Cache;
    
    use Cheukpang\NotORM\ICache;
    
    /**
     * Class APC
     * Cache using "NotORM." prefix in APC
     * @package Cheukpang\NotORM\Cache
     */
    class APC implements ICache
    {
        
        public function load($key)
        {
            $return = apc_fetch("NotORM.$key", $success);
            if ( ! $success) {
                return null;
            }
            
            return $return;
        }
        
        public function save($key, $data)
        {
            apc_store('NotORM'.$key, $data);
        }
        
    }
