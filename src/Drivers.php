<?php

namespace Indigoram89\Laravel\Translations;

use InvalidArgumentException;
use Indigoram89\Laravel\Translations\Drivers\Lokalise;
use Indigoram89\Laravel\Translations\Contracts\Driver as DriverContract;
use Indigoram89\Laravel\Translations\Contracts\Drivers as DriversContract;

class Drivers implements DriversContract
{
    protected $config;

    protected $drivers = [];

    public function __construct($app)
    {
        $this->config = $app['config']['translations'];
    }

    public function get(string $driver = null) : DriverContract
    {
        $driver = $driver ?: $this->getDefaultDriver();

        if (isset($this->drivers[$driver])) {
        	return $this->drivers[$driver];
        }

        return $this->drivers[$driver] = $this->resolve($driver);
    }

    public function getDefaultDriver() : string
    {
        return $this->getConfig('driver');
    }

    protected function resolve(string $driver) : DriverContract
    {
        $config = $this->getConfig($driver);

        if (is_null($config)) {
            throw new InvalidArgumentException("Driver [{$driver}] is not defined.");
        }

        $method = 'create'.ucfirst($driver).'Driver';

        if (method_exists($this, $method)) {
            return $this->{$method}($config);
        } else {
            throw new InvalidArgumentException("Driver [{$driver}] is not supported.");
        }
    }

    protected function createLokaliseDriver(array $config) : DriverContract
    {
        return new Lokalise($config);
    }

    protected function getConfig(string $key)
    {
        return array_get($this->config, $key);
    }
}
