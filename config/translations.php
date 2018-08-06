<?php

return [
	'driver' => env('TRANSLATIONS_DRIRVER', 'lokalise'),

	'lokalise' => [
		'driver' => 'lokalise',
		'token' => env('LOKALISE_TOKEN'),
		'project' => env('LOKALISE_PROJECT'),
	],

	'search' => [
		'resources/views',
		'routes',
		'app',
	],
];