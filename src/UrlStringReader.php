<?php

interface UrlStringReader {

	public function readStringFromUrl( string $url, int $length ): string;

}
