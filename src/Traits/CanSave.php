<?php

namespace Indigoram89\Laravel\Translations\Traits;

trait CanSave
{
	public function save(array $translations) : int
	{
		$this->saveJSON($translations);
		
		// $this->savePHP($translations);

		return count($translations);
	}

	protected function saveJSON(array $translations)
	{
		$files = [];

		$default = $this->getLocale();

		foreach ($translations as $key => $values) {
			foreach ($values as $locale => $value) {
				$files[$locale][$key] = $this->clearValue($key, $value)
					?: $this->clearValue($key, $translations[$key][$default]);
			}
		}

		foreach ($files as $file => $content) {
			$this->saveFile(
				base_path("resources/lang/{$file}.json"),
				json_encode($content, JSON_UNESCAPED_UNICODE)
			);
		}
	}

	protected function savePHP(array $translations)
	{
		$files = [];

		foreach ($translations as $key => $values) {
			if (list($namespace, $group, $item) = $this->parseKey($key)) {
				foreach ($values as $locale => $value) {
					$files[$locale][$group][$item] = $this->clearValue($key, $value);
				}
			}
		}

		foreach ($files as $locale => $groups) {
			foreach ($groups as $file => $content) {

				$content = var_export($content, true);

				$this->makeDirectory(base_path("resources/lang/{$locale}"));
			
				$this->saveFile(
					base_path("resources/lang/{$locale}/{$file}.php"),
					"<?php return {$content};"
				);
			}
		}
	}

	protected function isKey(string $key)
	{
		return preg_match('/^[a-z]+\./', $key);
	}

	protected function parseKey(string $key)
	{
		if ($this->isKey($key)) {
			return $this->translator->parseKey($key);
		}
	}

	protected function clearValue(string $key, string $value = null)
	{
		if ($value === '') return null;

		return $value;
	}
}