<?php

namespace Indigoram89\Laravel\Translations\Traits;

trait CanFiles
{
	protected function fileExists(string $path) : bool
	{
		return $this->files->exists($path);
	}

	protected function getFiles(string $path) : array
	{
		return $this->files->allFiles($path);
	}

	protected function getFile(string $path) :? string
	{
		if ($this->files->exists($path)) {
			return $this->files->get($path);
		}

		return null;
	}

	protected function saveFile(string $file, string $content) : bool
	{
		return $this->files->put($file, $content);
	}

	protected function makeDirectory(string $path) : bool
	{
		if ($this->fileExists($path)) {
			return false;
		}
		
		return $this->files->makeDirectory($path);
	}
}