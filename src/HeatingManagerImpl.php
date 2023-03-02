<?php

class HeatingManagerImpl {
	public function manageHeating( float $temperature, float $threshold ): void {
		if ( $temperature < $threshold ) {
			if ( !( $socket = socket_create( AF_INET, SOCK_STREAM, 0 ) ) ) {
				throw new RuntimeException( 'could not create socket' );
			}
			if ( !socket_connect( $socket, 'heater.home', 9999 ) ) {
				throw new RuntimeException( 'could not connect!' );
			}
			$message = "on";
			socket_send( $socket, $message, strlen( $message ), 0 );
			socket_close( $socket );
		} elseif ( $temperature > $threshold ) {
			if ( !( $socket = socket_create( AF_INET, SOCK_STREAM, 0 ) ) ) {
				throw new RuntimeException( 'could not create socket' );
			}
			if ( !socket_connect( $socket, 'heater.home', 9999 ) ) {
				throw new RuntimeException( 'could not connect!' );
			}
			$message = "off";
			socket_send( $socket, $message, strlen( $message ), 0 );
			socket_close( $socket );
		}
	}
}
