<?php

class HeatingManagerImpl {

	public function __construct(
		private readonly HeaterController $heaterController = new SocketHeaterController()
	) {
	}

	public function manageHeating( float $temperature, float $threshold ): void {
		if ( $temperature < $threshold ) {
			$this->heaterController->turnOn();
		} elseif ( $temperature > $threshold ) {
			$this->heaterController->turnOff();
		}
	}
}
