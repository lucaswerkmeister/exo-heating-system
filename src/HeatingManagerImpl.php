<?php

class HeatingManagerImpl {
	public function manageHeating( float $temperature, float $threshold ): void {
		if ( $temperature < $threshold ) {
			$this->sendToSocket( 'on' );
		} elseif ( $temperature > $threshold ) {
			$this->sendToSocket( 'off' );
		}
	}

	private function sendToSocket( string $message ): void {
		if ( !( $socket = socket_create( AF_INET, SOCK_STREAM, 0 ) ) ) {
			throw new RuntimeException( 'could not create socket' );
		}
		if ( !socket_connect( $socket, 'heater.home', 9999 ) ) {
			throw new RuntimeException( 'could not connect!' );
		}
		socket_send( $socket, $message, strlen( $message ), 0 );
		socket_close( $socket );
	}
}
