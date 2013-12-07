<?php

echo exec( 'composer update' ) . "\n";

if ( is_readable( __DIR__ . '/../vendor/autoload.php') ) {
	require_once( __DIR__ . '/../vendor/autoload.php' );
}
