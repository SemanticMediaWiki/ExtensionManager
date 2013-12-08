<?php

namespace ExtensionManager;

use Html;

/**
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class HtmlFormatter {

	/**
	 * @since 0.1
	 *
	 * @param Html $html
	 */
	public function __construct( Html $html ) {
		$this->html = $html;
	}

	/**
	 * @since 0.1
	 *
	 * @return string
	 */
	public function createElement( $element, $contents = '', $attribs = array() ) {
		return call_user_func_array( array( $this->html, 'rawElement' ), array( $element, $attribs, $contents ) );
	}

}
