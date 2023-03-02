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
		$temperature = floatval( self::stringFromURL( "http://probe.home:9999/temp", 4 ) );

		$now = gettimeofday( true );
		if ( $now > self::startHour() && $now < self::endHour() ) {
			$heatingManager->manageHeating( $temperature, floatval( $threshold ) );
		}
	}

	private static function endHour(): float {
		return floatval( self::stringFromURL( "http://timer.home:9990/end", 5 ) );
	}

	private static function stringFromURL( string $url, int $length ) {
		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

		$output = curl_exec( $curl );

		curl_close( $curl );

		return substr( $output, 0, $length );
	}

	private static function startHour(): float {
		return floatval( self::stringFromURL( "http://timer.home:9990/start", 5 ) );
	}
}
