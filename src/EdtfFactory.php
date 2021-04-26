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

	private const I18N_DIR = __DIR__ . "/../i18n";

	public static function newParser(): EdtfParser {
		return new SaneParser();
	}

	public static function newValidator(): EdtfValidator {
		return Validator::newInstance();
	}

	/**
	 * Humanizer that returns a single string. Does not support sets.
	 * If you want set support, use the more complex StructuredHumanizer returned by @see newStructuredHumanizerForLanguage.
	 *
	 * @throws LoaderException
	 */
	public static function newHumanizerForLanguage(
		string $languageCode,
		string $fallbackLanguageCode = 'en',
		string $translationDir = self::I18N_DIR
	): Humanizer {
		return new InternationalizedHumanizer(
			self::newMessageBuilder( $languageCode, $fallbackLanguageCode, $translationDir ),
			self::getLanguageStrategy( $languageCode )
		);
	}

	/**
	 * @throws LoaderException
	 */
	public static function newStructuredHumanizerForLanguage(
		string $languageCode,
		string $fallbackLanguageCode = 'en',
		string $translationDir = self::I18N_DIR
	): StructuredHumanizer {
		return new PrivateStructuredHumanizer(
			self::newHumanizerForLanguage( $languageCode, $fallbackLanguageCode, $translationDir ),
			self::newMessageBuilder( $languageCode, $fallbackLanguageCode, $translationDir )
		);
	}

	/**
	 * @throws LoaderException
	 */
	private static function newMessageBuilder(
		string $languageCode,
		string $fallbackLanguageCode,
		string $translationDir
	): MessageBuilder {
		$loader = new JsonFileLoader( $translationDir );

		if ( $languageCode === $fallbackLanguageCode ) {
			return new ArrayMessageBuilder( $loader->load( $languageCode ) );
		}

		return new FallbackMessageBuilder(
			new ArrayMessageBuilder( $loader->load( $languageCode ) ),
			new ArrayMessageBuilder( $loader->load( $fallbackLanguageCode ) )
		);
	}

	private static function getLanguageStrategy( string $languageCode ): LanguageStrategy {
		switch ( $languageCode ) {
			case "fr":
				return new FrenchStrategy();
		}

		return new EnglishStrategy();
	}
}
