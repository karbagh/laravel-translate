<?php

namespace Karbagh\LaravelTranslate\Services;

use Illuminate\Translation\FileLoader;
use Karbagh\LaravelTranslate\Loaders\TranslationLoader;
use Karbagh\LaravelTranslate\Models\Translation;

class TranslationLoaderService extends FileLoader
{
	public function load($locale, $group, $namespace = null): array
	{
		try {
			$fileTranslations = parent::load($locale, $group, $namespace);

			if (!is_null($namespace) && $namespace !== '*') {
				return $fileTranslations;
			}

			$loaderTranslations = TranslationLoader::loadTranslations($locale, $group, $namespace);

			return array_merge($fileTranslations, $loaderTranslations[0] ?? []);
		} catch (QueryException $e) {
			$modelClass = config('translate.model');
			$model = new $modelClass;
			if (is_a($model, Translation::class)) {
				if (! Schema::hasTable($model->getTable())) {
					return parent::load($locale, $group, $namespace);
				}
			}

			throw $e;
		}
	}
}
