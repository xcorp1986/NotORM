<?php
	namespace PhalApi\NotORM\Cache;
	
	use PhalApi\NotORM\Cache;
	
	
	/**
	 * Class Session
	 * Cache using $_SESSION["NotORM"]
	 * @package PhalApi\NotORM\Cache
	 */
	class Session implements Cache {
		
		function load( $key ) {
			if ( ! isset( $_SESSION['NotORM'][ $key ] ) ) {
				return null;
			}
			
			return $_SESSION['NotORM'][ $key ];
		}
		
		function save( $key, $data ) {
			$_SESSION['NotORM'][ $key ] = $data;
		}
		
	}
