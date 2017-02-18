<?php
    namespace Cheukpang\NotORM\Cache;
    
    use Cheukpang\NotORM\ICache;
    
    
    /**
     * Class Session
     * Cache using $_SESSION["NotORM"]
     * @package Cheukpang\NotORM\Cache
     */
    class Session implements ICache
    {
        
        public function load($key)
        {
            if ( ! isset($_SESSION['NotORM'][$key])) {
                return null;
            }
            
            return $_SESSION['NotORM'][$key];
        }
        
        public function save($key, $data)
        {
            $_SESSION['NotORM'][$key] = $data;
        }
        
    }
