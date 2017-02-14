<?php
	namespace PhalApi\NotORM;
	
	/**
	 * SQL literal value
	 */
	class Literal {
		/**
		 * @var array $parameters
		 */
		public $parameters = [];
		protected $value = '';
		
		/**
		 * Create literal value
		 *
		 * @param string
		 *
		 * @internal  mixed parameter
		 * @internal  mixed ...
		 */
		function __construct( $value ) {
			$this->value      = $value;
			$this->parameters = func_get_args();
			array_shift( $this->parameters );
		}
		
		/**
		 * Get literal value
		 * @return string
		 */
		function __toString() {
			return $this->value;
		}
		
	}
