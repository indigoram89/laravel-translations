<?php

namespace Indigoram89\Laravel\Translations\Contracts;

interface Driver
{
	public function push(array $translations) : int;
	
	public function pull() : array;
}