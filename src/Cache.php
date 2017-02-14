<?php
	namespace PhalApi\NotORM;
	
	/**
	 * Interface Cache
	 * Loading and saving data, it's only cache so load() does not need to block until save()
	 * @package PhalApi\NotORM
	 */
	interface Cache {
		
		/** Load stored data
		 *
		 * @param string
		 *
		 * @return mixed or null if not found
		 */
		function load( $key );
		
		/** Save data
		 *
		 * @param string
		 * @param mixed
		 *
		 * @return null
		 */
		function save( $key, $data );
		
	}
	