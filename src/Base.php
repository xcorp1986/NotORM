<?php
	namespace PhalApi\NotORM;
	
	/**
	 * Class Base
	 * friend visibility emulation
	 * @package PhalApi\NotORM
	 */
	class Base {
		/**
		 * @var $connection \PDO
		 */
		protected $connection;
		protected $driver;
		/**
		 * @var $structure Structure
		 */
		protected $structure;
		/**
		 * @var $cache Cache
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
		protected $isKeepPrimaryKeyIndex = false; //@dogstar 20151230
		
		protected function access( $key, $delete = false ) {
		}
	}