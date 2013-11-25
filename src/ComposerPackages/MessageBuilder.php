<?php

namespace ComposerPackages;

use IContextSource;

/**
 * Provides access to the Message object
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class MessageBuilder {

	/**
	 * @since 0.1
	 *
	 * @param IContextSource $context
	 */
	public function __construct( IContextSource $context ) {
		$this->context = $context;
	}

	/**
	 * @since 0.1
	 *
	 * @return Message
	 */
	public function getText() {
		$message = $this->msg( func_get_args() );
		return $message->text();
	}

	/**
	 * @since 0.1
	 *
	 * @return Message
	 */
	protected function msg() {
		$message = call_user_func_array( array( $this->context, 'msg' ), func_get_args() );
		return $message;
	}
}
