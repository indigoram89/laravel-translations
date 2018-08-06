<?php

namespace Indigoram89\Laravel\Translations;

use Indigoram89\Laravel\Translations\Contracts\Driver as DriverContract;
use Indigoram89\Laravel\Translations\Contracts\Repository as RepositoryContract;
use Indigoram89\Laravel\Translations\Contracts\Translations as TranslationsContract;

class Translations implements TranslationsContract
{
	protected $repository;
	
	protected $drivers;

	public function __construct($app)
	{
		$this->repository = $app['translations.repository'];
		
		$this->drivers = $app['translations.drivers'];
	}
	
	public function repository() : RepositoryContract
	{
		return $this->repository;
	}

	public function driver(string $driver = null) : DriverContract
	{
		return $this->drivers->get($driver);
	}
}