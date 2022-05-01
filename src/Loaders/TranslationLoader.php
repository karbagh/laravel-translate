<?php

namespace  Karbagh\LaravelTranslate\Loaders;

use Karbagh\LaravelTranslate\Exceptions\InvalidConfiguration;
use Karbagh\LaravelTranslate\Models\Translation;

class TranslationLoader
{
	public static function loadTranslations(string $locale, string $group): array
	{
		$model = self::getConfiguredModelClass();

		return $model::getTranslations($locale, $group);
	}

	protected static function getConfiguredModelClass(): string
	{
		$modelClass = config('translate.model');

		if (! is_a(new $modelClass, Translation::class)) {
			throw InvalidConfiguration::invalidModel($modelClass);
		}

		return $modelClass;
	}
}
