<?php
    namespace Cheukpang\NotORM\Cache;
    
    use Cheukpang\NotORM\ICache;
    
    /**
     * Class File
     * Cache using file
     * @package Cheukpang\NotORM\Cache
     */
    class File implements ICache
    {
        private $filename, $data = [];
        
        public function __construct($filename)
        {
            $this->filename = $filename;
            $this->data     = unserialize(@file_get_contents($filename)); // @ - file may not exist
        }
        
        public function load($key)
        {
            if ( ! isset($this->data[$key])) {
                return null;
            }
            
            return $this->data[$key];
        }
        
        public function save($key, $data)
        {
            if ( ! isset($this->data[$key]) || $this->data[$key] !== $data) {
                $this->data[$key] = $data;
                file_put_contents($this->filename, serialize($this->data), LOCK_EX);
            }
        }
        
    }
