<?php

namespace Indigoram89\Laravel\Translations\Traits;

trait CanSearch
{
	public function search() : array
	{
		$locale = $this->getLocale();
		
		$translations = [];

		foreach ($this->getConfig('search') as $path) {
			$translations = array_merge(
				$translations,
				$this->searchTexts($path, $locale)
			);
		}

        return $translations;
	}

	protected function searchTexts(string $path, string $locale) : array
	{
		$texts = [];

		foreach ($this->getFiles($path) as $file) {
        	$content = $this->getFile($file);

        	foreach ($this->searchKeys($content) as $key) {
        		$texts[$key] = [$locale => $this->parseValue($key, __($key))];
        	}
        }

        return $texts;
	}

	protected function searchKeys(string $content) : array
	{
		$keys = [];
	
		$pattern = '/(__\([\'"])(.+?)([\'"]\))/';

		if (preg_match_all($pattern, $content, $matches)) {
            foreach ($matches[0] as $match) {
            	$keys[] = preg_replace($pattern, '$2', $match);
            }
        }

        return $keys;
	}
}