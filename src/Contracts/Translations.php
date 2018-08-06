<?php

namespace Indigoram89\Laravel\Translations\Contracts;

use Indigoram89\Laravel\Translations\Contracts\Driver as DriverContract;
use Indigoram89\Laravel\Translations\Contracts\Repository as RepositoryContract;

interface Translations
{
	public function repository() : RepositoryContract;
	
	public function driver(string $driver = null) : DriverContract;
}