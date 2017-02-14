<?php
	namespace PhalApi\NotORM\Cache;
	
	use PhalApi\NotORM\Cache;
	
	/**
	 * Class APC
	 * Cache using "NotORM." prefix in APC
	 * @package PhalApi\NotORM\Cache
	 */
	class APC implements Cache {
		
		function load($key) {
			$return = apc_fetch("NotORM.$key", $success);
			if (!$success) {
				return null;
			}
			return $return;
		}
		
		function save($key, $data) {
			apc_store("NotORM.$key", $data);
		}
		
	}
