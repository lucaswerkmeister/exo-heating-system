<?php

class CurlUrlStringReader implements UrlStringReader {

	public function readStringFromUrl( string $url, int $length ): string {
		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

		$output = curl_exec( $curl );

		curl_close( $curl );

		return substr( $output, 0, $length );
	}

}
