<?php
	namespace PhalApi\NotORM;
	
	use ArrayAccess;
	use ArrayIterator;
	use Countable;
	use IteratorAggregate;
	use JsonSerializable;
	
	/**
	 * Single row representation
	 */
	class Row extends Base implements IteratorAggregate, ArrayAccess, Countable, JsonSerializable {
		protected $row, $result, $primary;
		private $modified = [];
		
		/**
		 * @access protected must be public because it is called from Result
		 *
		 * @param array                  $row
		 * @param \PhalApi\NotORM\Result $result
		 */
		function __construct( array $row, Result $result ) {
			$this->row    = $row;
			$this->result = $result;
			if ( array_key_exists( $result->primary, $row ) ) {
				$this->primary = $row[ $result->primary ];
			}
		}
		
		/**
		 * Get primary key value
		 * @return string
		 */
		function __toString() {
			return (string) $this[ $this->result->primary ]; // (string) - PostgreSQL returns int
		}
		
		/**
		 * Test if referenced row exists
		 *
		 * @param string
		 *
		 * @return bool
		 */
		function __isset( $name ) {
			return ( $this->__get( $name ) !== null );
		}
		
		/**
		 * Get referenced row
		 *
		 * @param string $name
		 *
		 * @return Row or null if the row does not exist
		 */
		function __get( $name ) {
			$column     = $this->result->notORM->structure->getReferencedColumn( $name, $this->result->table );
			$referenced = &$this->result->referenced[ $name ];
			if ( ! isset( $referenced ) ) {
				$keys = [];
				foreach ( $this->result->rows as $row ) {
					if ( $row[ $column ] !== null ) {
						$keys[ $row[ $column ] ] = null;
					}
				}
				if ( $keys ) {
					$table      = $this->result->notORM->structure->getReferencedTable( $name, $this->result->table );
					$referenced = new Result( $table, $this->result->notORM );
					$referenced->where( "$table." . $this->result->notORM->structure->getPrimary( $table ), array_keys( $keys ) );
				} else {
					$referenced = [];
				}
			}
			if ( ! isset( $referenced[ $this[ $column ] ] ) ) { // referenced row may not exist
				return null;
			}
			
			return $referenced[ $this[ $column ] ];
		}
		
		/**
		 * Store referenced value
		 *
		 * @param string $name
		 * @param Row    $value or null
		 *
		 * @return null
		 */
		function __set( $name, Row $value = null ) {
			$column          = $this->result->notORM->structure->getReferencedColumn( $name, $this->result->table );
			$this[ $column ] = $value;
		}
		
		/**
		 * Remove referenced column from data
		 *
		 * @param string $name
		 *
		 * @return null
		 */
		function __unset( $name ) {
			$column = $this->result->notORM->structure->getReferencedColumn( $name, $this->result->table );
			unset( $this[ $column ] );
		}
		
		/**
		 * Get referencing rows
		 *
		 * @param string $name table name
		 * @param array  $args (["condition"[, array("value")]])
		 *
		 * @return MultiResult
		 */
		function __call( $name, array $args ) {
			$table  = $this->result->notORM->structure->getReferencingTable( $name, $this->result->table );
			$column = $this->result->notORM->structure->getReferencingColumn( $table, $this->result->table );
			$return = new MultiResult( $table, $this->result, $column, $this[ $this->result->primary ] );
			$return->where( "$table.$column", array_keys( (array) $this->result->rows ) ); // (array) - is null after insert
			if ( $args ) {
				call_user_func_array( [ $return, 'where' ], $args );
			}
			
			return $return;
		}
		
		/**
		 * Update row
		 *
		 * @param array $data or null for all modified values
		 *
		 * @return int number of affected rows or false in case of an error
		 */
		function update( $data = null ) {
			// update is an SQL keyword
			if ( ! isset( $data ) ) {
				$data = $this->modified;
			}
			$result        = new Result( $this->result->table, $this->result->notORM );
			$return        = $result->where( $this->result->primary, $this->primary )->update( $data );
			$this->primary = $this[ $this->result->primary ];
			
			return $return;
		}
		
		/**
		 * Delete row
		 * @return int number of affected rows or false in case of an error
		 */
		function delete() {
			// delete is an SQL keyword
			$result        = new Result( $this->result->table, $this->result->notORM );
			$return        = $result->where( $this->result->primary, $this->primary )->delete();
			$this->primary = $this[ $this->result->primary ];
			
			return $return;
		}
		
		function getIterator() {
			$this->access( null );
			
			return new ArrayIterator( $this->row );
		}
		
		/**
		 * IteratorAggregate implementation
		 * @param      $key
		 * @param bool $delete
		 */
		protected function access( $key, $delete = false ) {
			if ( $this->result->notORM->cache && ! isset( $this->modified[ $key ] ) && $this->result->access( $key, $delete ) ) {
				$id        = ( isset( $this->primary ) ? $this->primary : $this->row );
				$this->row = $this->result[ $id ]->row;
			}
		}
		
		/**
		 * Countable implementation
		 * @return int
		 */
		function count() {
			return count( $this->row );
		}
		
		/**
		 * ArrayAccess implementation
		 * Test if column exists
		 *
		 * @param string $key column name
		 *
		 * @return bool
		 */
		function offsetExists( $key ) {
			$this->access( $key );
			$return = array_key_exists( $key, $this->row );
			if ( ! $return ) {
				$this->access( $key, true );
			}
			
			return $return;
		}
		
		/**
		 * Get value of column
		 *
		 * @param string $key column name
		 *
		 * @return string
		 */
		function offsetGet( $key ) {
			$this->access( $key );
			if ( ! array_key_exists( $key, $this->row ) ) {
				$this->access( $key, true );
			}
			
			return $this->row[ $key ];
		}
		
		/**
		 * Store value in column
		 *
		 * @param string $key column name
		 *
		 * @return null
		 */
		function offsetSet( $key, $value ) {
			$this->row[ $key ]      = $value;
			$this->modified[ $key ] = $value;
		}
		
		/**
		 * Remove column from data
		 *
		 * @param string $key column name
		 *
		 * @return null
		 */
		function offsetUnset( $key ) {
			unset( $this->row[ $key ] );
			unset( $this->modified[ $key ] );
		}
		
		/**
		 * JsonSerializable implementation
		 * @return array
		 */
		function jsonSerialize() {
			return $this->row;
		}
		
		// @dogstar 2014-10-24
		function toArray() {
			return $this->row();
		}
		
	}
