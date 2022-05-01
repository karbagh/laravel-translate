<?php

namespace  Karbagh\LaravelTranslate\Exceptions;

use Exception;
use Karbagh\LaravelTranslate\Models\Translation;

class InvalidConfiguration extends Exception
{
	public static function invalidModel(string $className): self
	{
		$modelClass = Translation::class;

		return new static("You have configured an invalid class `{$className} 
				A valid class extends {$modelClass}");
	}
}