<?php

class HeatingManagerImpl {

	public function __construct(
		private readonly UrlStringReader $urlStringReader = new CurlUrlStringReader(),
		private readonly HeaterController $heaterController = new SocketHeaterController()
	) {
	}

	public function manageHeating( float $threshold ): void {
		$temperature = floatval( $this->urlStringReader->readStringFromUrl( "http://probe.home:9999/temp", 4 ) );
		if ( $temperature < $threshold ) {
			$this->heaterController->turnOn();
		} elseif ( $temperature > $threshold ) {
			$this->heaterController->turnOff();
		}
	}
}
