<?php
	namespace PhalApi\NotORM\Cache;
	
	use PhalApi\NotORM\Cache;
	
	/**
	 * Class File
	 * Cache using file
	 * @package PhalApi\NotORM\Cache
	 */
	class File implements Cache {
		private $filename, $data = [];
		
		function __construct( $filename ) {
			$this->filename = $filename;
			$this->data     = unserialize( @file_get_contents( $filename ) ); // @ - file may not exist
		}
		
		function load( $key ) {
			if ( ! isset( $this->data[ $key ] ) ) {
				return null;
			}
			
			return $this->data[ $key ];
		}
		
		function save( $key, $data ) {
			if ( ! isset( $this->data[ $key ] ) || $this->data[ $key ] !== $data ) {
				$this->data[ $key ] = $data;
				file_put_contents( $this->filename, serialize( $this->data ), LOCK_EX );
			}
		}
		
	}
