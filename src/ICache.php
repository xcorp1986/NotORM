<?php
    namespace Cheukpang\NotORM;
    
    /**
     * Interface Cache
     * Loading and saving data, it's only cache so load() does not need to block until save()
     * @package Cheukpang\NotORM
     */
    interface ICache
    {
        
        /** Load stored data
         *
         * @param string
         *
         * @return mixed or null if not found
         */
        public function load($key);
        
        /** Save data
         *
         * @param string
         * @param mixed
         *
         * @return null
         */
        public function save($key, $data);
        
    }
	