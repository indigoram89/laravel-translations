<?php

namespace Indigoram89\Laravel\Translations;

use Illuminate\Support\Arr;
use Indigoram89\Laravel\Translations\Traits\CanSave;
use Indigoram89\Laravel\Translations\Traits\CanFiles;
use Indigoram89\Laravel\Translations\Traits\CanSearch;
use Indigoram89\Laravel\Translations\Contracts\Repository as RepositoryContract;

class Repository implements RepositoryContract
{
	use CanSearch, CanSave, CanFiles;

	protected $config;
	
	protected $translator;
	
	protected $files;
	
	protected $locale;

	public function __construct($app)
	{
		$this->config = $app['config']['translations'];
		
		$this->translator = $app['translator'];

		$this->files = $app['files'];
		
		$this->locale = $app['config']['app']['locale'];
	}

	protected function getConfig(string $key)
	{
		return Arr::get($this->config, $key);
	}

	protected function getLocale()
	{
		return $this->locale;
	}
}