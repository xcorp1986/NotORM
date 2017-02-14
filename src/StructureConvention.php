<?php
	namespace PhalApi\NotORM;
	
	/**
	 * Class StructureConvention
	 * Structure described by some rules
	 * @package PhalApi\NotORM
	 */
	class StructureConvention implements Structure {
		protected $primary, $foreign, $table, $prefix;
		
		/**
		 * Create conventional structure
		 *
		 * @param string $primary %s stands for table name
		 * @param string $foreign %1$s stands for key used after ->, %2$s for table name
		 * @param string $table   %1$s stands for key used after ->, %2$s for table name
		 * @param string $prefix  prefix for all tables
		 */
		function __construct( $primary = 'id', $foreign = '%s_id', $table = '%s', $prefix = '' ) {
			$this->primary = $primary;
			$this->foreign = $foreign;
			$this->table   = $table;
			$this->prefix  = $prefix;
		}
		
		function getPrimary( $table ) {
			return sprintf( $this->primary, $this->getColumnFromTable( $table ) );
		}
		
		protected function getColumnFromTable( $name ) {
			if ( $this->table != '%s' && preg_match( '(^' . str_replace( '%s', '(.*)', preg_quote( $this->table ) ) . '$)', $name, $match ) ) {
				return $match[1];
			}
			
			return $name;
		}
		
		function getReferencingColumn( $name, $table ) {
			return $this->getReferencedColumn( substr( $table, strlen( $this->prefix ) ), $this->prefix . $name );
		}
		
		function getReferencedColumn( $name, $table ) {
			return sprintf( $this->foreign, $this->getColumnFromTable( $name ), substr( $table, strlen( $this->prefix ) ) );
		}
		
		function getReferencingTable( $name, $table ) {
			return $this->prefix . $name;
		}
		
		function getReferencedTable( $name, $table ) {
			return $this->prefix . sprintf( $this->table, $name, $table );
		}
		
		function getSequence( $table ) {
			return null;
		}
		
	}
