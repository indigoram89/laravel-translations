<?php

namespace Indigoram89\Laravel\Translations\Facades;

use Illuminate\Support\Facades\Facade;

class Translations extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'translations';
	}
}