<?php

declare( strict_types = 1 );

namespace EDTF;

use EDTF\PackagePrivate\Humanizer\Internationalization\ArrayMessageBuilder;
use EDTF\PackagePrivate\Humanizer\InternationalizedHumanizer;
use EDTF\PackagePrivate\Humanizer\PrivateStructuredHumanizer;
use EDTF\PackagePrivate\Humanizer\Strategy\EnglishStrategy;
use EDTF\PackagePrivate\Humanizer\Strategy\FrenchStrategy;
use EDTF\PackagePrivate\SaneParser;
use EDTF\PackagePrivate\Validator;

class EdtfFactory {

	public static function newParser(): EdtfParser {
		return new SaneParser();
	}

	public static function newValidator(): EdtfValidator {
		return Validator::newInstance();
	}

	public static function newHumanizerForLanguage( string $languageCode ): Humanizer {
		if ( $languageCode === 'fr' ) {
		    $messageBuilder = new ArrayMessageBuilder([
                'edtf-maybe-circa' => 'Circa $1 (incertain)',
                'edtf-circa' => 'Circa $1',
                'edtf-maybe' => '$1 (incertain)',

		        'edtf-full-date' => '$3 $2 $1',
                'edtf-season-and-year' => '$1 $2',
                'edtf-spring' => 'Printemps', // TODO: add another seasons (see EN keys)

                'edtf-day-and-year' => '$1 of unknown month, $2',
                'edtf-bc-year' => '$1 avant JC',
                'edtf-bc-year-short' => 'Année $1 avant JC',
                'edtf-year-short' => 'Année $1',

                // Months
                'edtf-january'   => 'janvier',
                'edtf-february'  => 'février',
                'edtf-march'     => 'mars',
                'edtf-april'     => 'avril',
                'edtf-may'       => 'mai',
                'edtf-june'      => 'juin',
                'edtf-july'      => 'juillet',
                'edtf-august'    => 'août',
                'edtf-september' => 'septembre',
                'edtf-october'   => 'octobre',
                'edtf-november'  => 'novembre',
                'edtf-december'  => 'decembre',

                // Intervals
                'edtf-interval-normal' => 'De $1 à $2',
                'edtf-interval-open-end' => 'De $1 (fin indéterminée)',
                'edtf-interval-open-start' => 'Jusqu’à $1',
                'edtf-interval-unknown-end' => 'Depuis $1 jusqu’à une fin inconnue',
                'edtf-interval-unknown-start' => 'Depuis un début inconnu jusqu’à $1',

                // Timezone
                'edtf-local-time' => 'heure locale',
            ]);

			return new InternationalizedHumanizer($messageBuilder, new FrenchStrategy());
		}

		return new InternationalizedHumanizer( new ArrayMessageBuilder(
			[
				'edtf-maybe-circa' => 'Maybe circa $1',
				'edtf-circa' => 'Circa $1',
				'edtf-maybe' => 'Maybe $1',

				'edtf-spring' => 'Spring',
				'edtf-summer' => 'Summer',
				'edtf-autumn' => 'Autumn',
				'edtf-winter' => 'Winter',
				'edtf-spring-north' => 'Spring (Northern Hemisphere)',
				'edtf-summer-north' => 'Summer (Northern Hemisphere)',
				'edtf-autumn-north' => 'Autumn (Northern Hemisphere)',
				'edtf-winter-north' => 'Winter (Northern Hemisphere)',
				'edtf-spring-south' => 'Spring (Southern Hemisphere)',
				'edtf-summer-south' => 'Summer (Southern Hemisphere)',
				'edtf-autumn-south' => 'Autumn (Southern Hemisphere)',
				'edtf-winter-south' => 'Winter (Southern Hemisphere)',
				'edtf-quarter-1' => 'First quarter',
				'edtf-quarter-2' => 'Second quarter',
				'edtf-quarter-3' => 'Third quarter',
				'edtf-quarter-4' => 'Fourth quarter',
				'edtf-quadrimester-1' => 'First quadrimester',
				'edtf-quadrimester-2' => 'Second quadrimester',
				'edtf-quadrimester-3' => 'Third quadrimester',
				'edtf-semester-1' => 'First semester',
				'edtf-semester-2' => 'Second semester',

				'edtf-full-date' => '$2 $3, $1',
				'edtf-season-and-year' => '$1 $2',

				'edtf-day-and-year' => '$1 of unknown month, $2',
                'edtf-bc-year' => '$1 BC',
                'edtf-bc-year-short' => 'Year $1 BC',
                'edtf-year-short' => 'Year $1',

                // Months
                'edtf-january' => 'January',
                'edtf-february' => 'February',
                'edtf-march' => 'March',
                'edtf-april' => 'April',
                'edtf-may' => 'May',
                'edtf-june' => 'June',
                'edtf-july' => 'July',
                'edtf-august' => 'August',
                'edtf-september' => 'September',
                'edtf-october' => 'October',
                'edtf-november' => 'November',
                'edtf-december' => 'December',

                // Intervals
                'edtf-interval-normal' => '$1 to $2',
                'edtf-interval-open-end' => '$1 or later',
                'edtf-interval-open-start' => '$1 or earlier',
                'edtf-interval-unknown-end' => 'From $1 to unknown',
                'edtf-interval-unknown-start' => 'From unknown to $1',

                // Timezone
                'edtf-local-time' => 'local time',
			]
		), new EnglishStrategy() );
	}

	public static function newStructuredHumanizerForLanguage( string $languageCode ): StructuredHumanizer {
		return new PrivateStructuredHumanizer(
			self::newHumanizerForLanguage( $languageCode )
		);
	}

}
