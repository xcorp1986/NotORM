<?php
	namespace PhalApi\NotORM;
	
	/**
	 * Interface Structure
	 * Information about tables and columns structure
	 * @package PhalApi\NotORM
	 */
	interface Structure {
		
		/**
		 * Get primary key of a table in $db->$table()
		 *
		 * @param string $table
		 *
		 * @return string
		 */
		function getPrimary( $table );
		
		/**
		 * Get column holding foreign key in $table[$id]->$name()
		 *
		 * @param string $name
		 * @param string $table
		 *
		 * @return string
		 */
		function getReferencingColumn( $name, $table );
		
		/**
		 * Get target table in $table[$id]->$name()
		 *
		 * @param string $name
		 * @param string $table
		 *
		 * @return string
		 */
		function getReferencingTable( $name, $table );
		
		/**
		 * Get column holding foreign key in $table[$id]->$name
		 *
		 * @param string $name
		 * @param string $table
		 *
		 * @return string
		 */
		function getReferencedColumn( $name, $table );
		
		/**
		 * Get table holding foreign key in $table[$id]->$name
		 *
		 * @param string $name
		 * @param string $table
		 *
		 * @return string
		 */
		function getReferencedTable( $name, $table );
		
		/**
		 * Get sequence name, used by insert
		 *
		 * @param string $table
		 *
		 * @return string
		 */
		function getSequence( $table );
		
	}