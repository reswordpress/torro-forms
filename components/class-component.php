<?php
/**
 * Awesome Forms Main Component Class
 *
 * This class is the base for every Awesome Forms Component.
 *
 * @author  awesome.ug, Author <support@awesome.ug>
 * @package AwesomeForms/Core
 * @version 2015-04-16
 * @since   1.0.0
 * @license GPL 2
 *
 * Copyright 2015 awesome.ug (support@awesome.ug)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

if( !defined( 'ABSPATH' ) ){
	exit;
}

abstract class AF_Component
{

	/**
	 * Title
	 *
	 * @since 1.0.0
	 */
	var $title;

	/**
	 * Name
	 *
	 * @since 1.0.0
	 */
	var $name;

	/**
	 * Description
	 *
	 * @since 1.0.0
	 */
	var $description;

	/**
	 * Initializing.
	 * @since 1.0.0
	 */
	public function __construct()
	{
		// Standard values
		$this->name = get_class( $this );
		$this->title = ucfirst( $this->name );
		$this->description = esc_attr__( 'This is a Awesome Forms component.', 'af-locale' );
	}

	/**
	 * Starting component
	 */
	abstract function start();

	/**
	 * Registering component
	 * @return bool
	 */
	public function _register()
	{
		global $af_global;

		if( !is_object( $af_global ) )
		{
			return FALSE;
		}

		$af_global->components[ $this->name ] = $this;

		add_action( 'init', array( $this, 'start_scripts' ), 20 );

		return TRUE;
	}

	public function start_scripts()
	{
		global $af_global;

		// @todo Make it easyier to acess data!
		$settings_handler = new AF_SettingsHandler( 'general', $af_global->settings[ 'general' ]->settings );
		$values = $settings_handler->get_field_values();

		if( is_array( $values[ 'modules' ] ) && in_array( $this->name, $values[ 'modules' ] ) ){
			$this->start();
		}
	}
}

/**
 * Registering component
 * @param $component_name
 */
function af_register_component( $component_name )
{
	if( class_exists( $component_name ) ){
		$component = new $component_name();
		return $component->_register();
	}
	return FALSE;
}