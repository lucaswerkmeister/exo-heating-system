<?php

class HeatingManagerImpl {
	public function manageHeating( float $t, float $threshold ): void {
		if ( $t < $threshold ) {
			try {
				if ( !( $s = socket_create( AF_INET, SOCK_STREAM, 0 ) ) ) {
					die( 'could not create socket' );
				}
				if ( !socket_connect( $s, 'heater.home', 9999 ) ) {
					die( 'could not connect!' );
				}
				$m = "on";
				socket_send( $s, $m, strlen( $m ), 0 );
				socket_close( $s );
			} catch ( Exception $e ) {
				echo 'Caught exception: ', $e->getMessage(), "\n";
			}
		} elseif ( $t > $threshold ) {
			try {
				if ( !( $s = socket_create( AF_INET, SOCK_STREAM, 0 ) ) ) {
					die( 'could not create socket' );
				}
				if ( !socket_connect( $s, 'heater.home', 9999 ) ) {
					die( 'could not connect!' );
				}
				$m = "off";
				socket_send( $s, $m, strlen( $m ), 0 );
				socket_close( $s );
			} catch ( Exception $e ) {
				echo 'Caught exception: ', $e->getMessage(), "\n";
			}
		}
	}
}
