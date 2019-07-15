<?php

return [
	'driver' => env('TRANSLATIONS_DRIVER', 'lokalise'),

	'lokalise' => [
		'driver' => 'lokalise',
		'token' => env('LOKALISE_TOKEN'),
		'project' => env('LOKALISE_PROJECT'),
	],

	'search' => [
		['path' => 'resources/views'],
		['path' => 'routes'],
		['path' => 'app'],
	],
];