<?php
/**
 * Form query class
 *
 * @package TorroForms
 * @since 1.0.0
 */

namespace awsmug\Torro_Forms\DB_Objects\Forms;

use Leaves_And_Love\Plugin_Lib\DB_Objects\Queries\Core_Query;

/**
 * Class representing a query for forms.
 *
 * @since 1.0.0
 */
class Form_Query extends Core_Query {
	/**
	 * Sets up the query for retrieving forms.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string|array $query Array or query string of form query arguments.
	 * @return awsmug\Torro_Forms\DB_Objects\Forms\Form_Collection Collection of forms.
	 */
	public function query( $query ) {
		$query = $this->map_args( $query );

		if ( isset( $query['fields'] ) && 'ids' !== $query['fields'] ) {
			$query['fields'] = '';
		}

		return parent::query( $query );
	}

	/**
	 * Instantiates the internal Core query object.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return object Internal Core query object.
	 */
	protected function instantiate_query_object() {
		return new WP_Query();
	}

	/**
	 * Parses the results of the internal Core query into a collection.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return awsmug\Torro_Forms\DB_Objects\Forms\Form_Collection Results as a collection.
	 */
	protected function parse_results_collection() {
		$ids = $this->original->posts;
		$fields = $this->original->query_vars['fields'];

		if ( 'ids' !== $fields ) {
			$ids = wp_list_pluck( $ids, 'ID' );
			$fields = 'objects';
		}

		return $this->create_collection( $ids, $this->original->found_posts, $fields );
	}

	/**
	 * Maps form query arguments to regular post query arguments.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @param array $args Arguments as `$query_var => $value` pairs.
	 * @return array Mapped arguments.
	 */
	protected function map_args( $args ) {
		$mapped_args = $args;
		foreach ( $args as $query_var => $value ) {
			switch ( $query_var ) {
				case 'slug':
					$mapped_args['post_name'] = $value;
					unset( $mapped_args['slug'] );
					break;
				case 'timestamp':
					unset( $mapped_args['timestamp'] );
					break;
				case 'timestamp_modified':
					unset( $mapped_args['timestamp_modified'] );
					break;
				case 'title':
				case 'author':
				case 'status':
					$mapped_args[ 'post_' . $query_var ] = $value;
			}
		}

		$mapped_args['post_type'] = $this->manager->get_prefix() . 'form';

		return $mapped_args;
	}
}