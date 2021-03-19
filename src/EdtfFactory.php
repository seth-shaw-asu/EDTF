<?php

declare( strict_types = 1 );

namespace EDTF;

use EDTF\PackagePrivate\Humanizer\Internationalization\ArrayMessageBuilder;
use EDTF\PackagePrivate\Humanizer\Internationalization\FallbackMessageBuilder;
use EDTF\PackagePrivate\Humanizer\Internationalization\MessageBuilder;
use EDTF\PackagePrivate\Humanizer\Internationalization\TranslationsLoader\JsonFileLoader;
use EDTF\PackagePrivate\Humanizer\Internationalization\TranslationsLoader\LoaderException;
use EDTF\PackagePrivate\Humanizer\InternationalizedHumanizer;
use EDTF\PackagePrivate\Humanizer\PrivateStructuredHumanizer;
use EDTF\PackagePrivate\Humanizer\Strategy\EnglishStrategy;
use EDTF\PackagePrivate\Humanizer\Strategy\FrenchStrategy;
use EDTF\PackagePrivate\Humanizer\Strategy\LanguageStrategy;
use EDTF\PackagePrivate\SaneParser;
use EDTF\PackagePrivate\Validator;

class EdtfFactory {

	public static function newParser(): EdtfParser {
		return new SaneParser();
	}

	public static function newValidator(): EdtfValidator {
		return Validator::newInstance();
	}

    /**
     * @throws LoaderException
     */
	public static function newHumanizerForLanguage( string $languageCode, string $fallbackLanguageCode = 'en' ): Humanizer
    {
        return new InternationalizedHumanizer(
        	self::newMessageBuilder($languageCode, $fallbackLanguageCode),
			self::getLanguageStrategy($languageCode)
		);
	}

	private static function newMessageBuilder( string $languageCode, string $fallbackLanguageCode ): MessageBuilder {
		$loader = new JsonFileLoader();

		if ($languageCode === $fallbackLanguageCode) {
			return $messageBuilder = new ArrayMessageBuilder($loader->load($languageCode));
		}

		return new FallbackMessageBuilder(
			new ArrayMessageBuilder($loader->load($languageCode)),
			new ArrayMessageBuilder($loader->load($fallbackLanguageCode))
		);
	}

    /**
     * @throws LoaderException
     */
	public static function newStructuredHumanizerForLanguage( string $languageCode ): StructuredHumanizer {
		return new PrivateStructuredHumanizer(
			self::newHumanizerForLanguage( $languageCode )
		);
	}

	private static function getLanguageStrategy(string $languageCode): LanguageStrategy
    {
        switch ($languageCode) {
            case "fr":
                return new FrenchStrategy();
        }

        return new EnglishStrategy();
    }
}
