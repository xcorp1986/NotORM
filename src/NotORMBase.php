<?php
    namespace Cheukpang\NotORM;
    
    /**
     * Class Base
     * friend visibility emulation
     * @package Cheukpang\NotORM
     */
    abstract class NotORMBase
    {
        /**
         * @var $connection \PDO
         */
        protected $connection;
        protected $driver;
        /**
         * @var $structure IStructure
         */
        protected $structure;
        /**
         * @var $cache ICache
         */
        protected $cache;
        /**
         * @var $notORM NotORM
         */
        protected $notORM;
        protected $table;
        protected $primary;
        protected $rows;
        protected $referenced = [];
        protected $debug = false;
        protected $debugTimer;
        protected $freeze = false;
        protected $rowClass = 'Row';
        protected $jsonAsArray = false;
        //@dogstar 20151230
        protected $isKeepPrimaryKeyIndex = false;
        
        protected function access($key, $delete = false)
        {
        }
    }