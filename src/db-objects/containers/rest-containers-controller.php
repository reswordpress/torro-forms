<?php
/**
 * REST containers controller class
 *
 * @package TorroForms
 * @since 1.0.0
 */

namespace awsmug\Torro_Forms\DB_Objects\Containers;

use Leaves_And_Love\Plugin_Lib\DB_Objects\REST_Models_Controller;

defined( 'ABSPATH' ) || exit;

/**
 * Class to access containers via the REST API.
 *
 * @since 1.0.0
 */
class REST_Containers_Controller extends REST_Models_Controller {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param Leaves_And_Love\Plugin_Lib\DB_Objects\Manager $manager The manager instance.
	 */
	public function __construct( $manager ) {
		parent::__construct( $manager );

		$this->namespace .= '/v1';
	}
}