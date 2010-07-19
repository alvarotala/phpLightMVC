<?php

	abstract class Object {
		private $params = array( );
		
		public function __construct( $params = array( )) {
			//parent::__construct( );
			$this->params = $params;
			
		}
		
		public function __get( $name) {
			if( array_key_exists( $name, $this->params)) {
				return $this->params[$name];
			}
			
			throw new Exception('Invalid Property');
					
		}
		
		public function __set( $name, $value) {
			if( array_key_exists( $name, $this->params)) {
				$this->params[$name] = $value;
			}
			
			throw new Exception('Invalid Property');
					
		}
		
		public function __call( $name, $args) {
			$result = preg_split( '/^find_by/', $name);
			if( !empty( $result[1])) return $this->find_by( substr( $result[1], 1), $args[0]);
			if( !method_exists( $this, $name)) {
				throw new Exception('Invalid Method');
			}
		}
		
		protected function has( $name) {
			return isset( $this->params[$name]);
		}	
		
		public function find_by( $field, $flag) {
			if( !$this->has( $field)) throw new Exception( 'Invalid Property');
			$model = strtolower( get_class( $this));
			$flag = is_string( $flag) ? "'$flag'" : $flag;
			
			
		}
		
	}
	
?>
