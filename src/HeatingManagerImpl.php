<?php

class HeatingManagerImpl {
	public function manageHeating( float $temperature, float $threshold ): void {
		if ( $temperature < $threshold ) {
			try {
				if ( !( $socket = socket_create( AF_INET, SOCK_STREAM, 0 ) ) ) {
					die( 'could not create socket' );
				}
				if ( !socket_connect( $socket, 'heater.home', 9999 ) ) {
					die( 'could not connect!' );
				}
				$message = "on";
				socket_send( $socket, $message, strlen( $message ), 0 );
				socket_close( $socket );
			} catch ( Exception $e ) {
				echo 'Caught exception: ', $e->getMessage(), "\n";
			}
		} elseif ( $temperature > $threshold ) {
			try {
				if ( !( $socket = socket_create( AF_INET, SOCK_STREAM, 0 ) ) ) {
					die( 'could not create socket' );
				}
				if ( !socket_connect( $socket, 'heater.home', 9999 ) ) {
					die( 'could not connect!' );
				}
				$message = "off";
				socket_send( $socket, $message, strlen( $message ), 0 );
				socket_close( $socket );
			} catch ( Exception $e ) {
				echo 'Caught exception: ', $e->getMessage(), "\n";
			}
		}
	}
}
