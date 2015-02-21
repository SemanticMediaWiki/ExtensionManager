<?php

namespace ServiceRegistry;

/**
 * Interface specifying a dependency container
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
interface ServiceContainer {

	/**
	 * Retrieves service definitions
	 *
	 * @since 0.1
	 *
	 * @return Closure
	 */
	public function loadAllDefinitions();

}
