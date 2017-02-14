<?php
	namespace PhalApi\NotORM\Cache;
	
	use PhalApi\NotORM\Cache;
	
	/**
	 * Class NotORM_Cache_Memcache
	 * Cache using "NotORM." prefix in Memcache
	 * @package PhalApi\NotORM\Cache
	 */
	class Memcache implements Cache {
		private $memcache;
		
		function __construct( \Memcache $memcache ) {
			$this->memcache = $memcache;
		}
		
		function load( $key ) {
			$return = $this->memcache->get( "NotORM.$key" );
			if ( $return === false ) {
				return null;
			}
			
			return $return;
		}
		
		function save( $key, $data ) {
			$this->memcache->set( "NotORM.$key", $data );
		}
		
	}
