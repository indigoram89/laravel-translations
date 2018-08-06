<?php

namespace Indigoram89\Laravel\Translations\Contracts;

use Indigoram89\Laravel\Translations\Contracts\Driver as DriverContract;

interface Drivers
{
	public function get(string $driver = null) : DriverContract;
}