<?php

/**
 * The system obtains temperature data from a remote source,
 * compares it with a given threshold and controls a remote heating
 * unit by switching it on and off. It does so only within a time
 * period configured on a remote service (or other source)
 *
 * This is purpose-built crap.
 */
class ScheduleManager {
	/**
	 * This method is the entry point into the code. You can assume that it is
	 * called at regular interval with the appropriate parameters.
	 */
	public static function manage( HeatingManagerImpl $heatingManager, string $threshold ): void {
		( new self( $heatingManager ) )->doManage( $threshold );
	}

	public function __construct(
		private readonly HeatingManagerImpl $heatingManager,
		private readonly UrlStringReader $urlStringReader = new CurlUrlStringReader() // TODO replace with Guzzle?
	) {
	}

	private function doManage( string $threshold ): void {
		$now = gettimeofday( true );
		if ( $now > $this->startHour() && $now < $this->endHour() ) {
			$this->heatingManager->manageHeating( floatval( $threshold ) );
		}
	}

	private function endHour(): float {
		return floatval( $this->urlStringReader->readStringFromUrl( "http://timer.home:9990/end", 5 ) );
	}

	private function startHour(): float {
		return floatval( $this->urlStringReader->readStringFromUrl( "http://timer.home:9990/start", 5 ) );
	}
}
