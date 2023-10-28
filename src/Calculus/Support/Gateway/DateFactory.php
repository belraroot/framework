<?php

namespace Calculus\Support;

use Carbon\Factory;
use InvalidArgumentException;

/**
 * @see https://carbon.nesbot.com/docs/
 * @see https://github.com/briannesbitt/Carbon/blob/master/src/Carbon/Factory.php
 *
 * @method \Calculus\Support\Carbon create($year = 0, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0, $tz = null)
 * @method \Calculus\Support\Carbon createFromDate($year = null, $month = null, $day = null, $tz = null)
 * @method \Calculus\Support\Carbon|false createFromFormat($format, $time, $tz = null)
 * @method \Calculus\Support\Carbon createFromTime($hour = 0, $minute = 0, $second = 0, $tz = null)
 * @method \Calculus\Support\Carbon createFromTimeString($time, $tz = null)
 * @method \Calculus\Support\Carbon createFromTimestamp($timestamp, $tz = null)
 * @method \Calculus\Support\Carbon createFromTimestampMs($timestamp, $tz = null)
 * @method \Calculus\Support\Carbon createFromTimestampUTC($timestamp)
 * @method \Calculus\Support\Carbon createMidnightDate($year = null, $month = null, $day = null, $tz = null)
 * @method \Calculus\Support\Carbon|false createSafe($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $tz = null)
 * @method void disableHumanDiffOption($humanDiffOption)
 * @method void enableHumanDiffOption($humanDiffOption)
 * @method mixed executeWithLocale($locale, $func)
 * @method \Calculus\Support\Carbon fromSerialized($value)
 * @method array getAvailableLocales()
 * @method array getDays()
 * @method int getHumanDiffOptions()
 * @method array getIsoUnits()
 * @method array getLastErrors()
 * @method string getLocale()
 * @method int getMidDayAt()
 * @method \Calculus\Support\Carbon|null getTestNow()
 * @method \Symfony\Component\Translation\TranslatorInterface getTranslator()
 * @method int getWeekEndsAt()
 * @method int getWeekStartsAt()
 * @method array getWeekendDays()
 * @method bool hasFormat($date, $format)
 * @method bool hasMacro($name)
 * @method bool hasRelativeKeywords($time)
 * @method bool hasTestNow()
 * @method \Calculus\Support\Carbon instance($date)
 * @method bool isImmutable()
 * @method bool isModifiableUnit($unit)
 * @method bool isMutable()
 * @method bool isStrictModeEnabled()
 * @method bool localeHasDiffOneDayWords($locale)
 * @method bool localeHasDiffSyntax($locale)
 * @method bool localeHasDiffTwoDayWords($locale)
 * @method bool localeHasPeriodSyntax($locale)
 * @method bool localeHasShortUnits($locale)
 * @method void macro($name, $macro)
 * @method \Calculus\Support\Carbon|null make($var)
 * @method \Calculus\Support\Carbon maxValue()
 * @method \Calculus\Support\Carbon minValue()
 * @method void mixin($mixin)
 * @method \Calculus\Support\Carbon now($tz = null)
 * @method \Calculus\Support\Carbon parse($time = null, $tz = null)
 * @method string pluralUnit(string $unit)
 * @method void resetMonthsOverflow()
 * @method void resetToStringFormat()
 * @method void resetYearsOverflow()
 * @method void serializeUsing($callback)
 * @method void setHumanDiffOptions($humanDiffOptions)
 * @method bool setLocale($locale)
 * @method void setMidDayAt($hour)
 * @method void setTestNow($testNow = null)
 * @method void setToStringFormat($format)
 * @method void setTranslator(\Symfony\Component\Translation\TranslatorInterface $translator)
 * @method void setUtf8($utf8)
 * @method void setWeekEndsAt($day)
 * @method void setWeekStartsAt($day)
 * @method void setWeekendDays($days)
 * @method bool shouldOverflowMonths()
 * @method bool shouldOverflowYears()
 * @method string singularUnit(string $unit)
 * @method \Calculus\Support\Carbon today($tz = null)
 * @method \Calculus\Support\Carbon tomorrow($tz = null)
 * @method void useMonthsOverflow($monthsOverflow = true)
 * @method void useStrictMode($strictModeEnabled = true)
 * @method void useYearsOverflow($yearsOverflow = true)
 * @method \Calculus\Support\Carbon yesterday($tz = null)
 */
class DateFactory
{
    const DEFAULT_CLASS_NAME = Carbon::class;

    protected static $dateClass;

    protected static $callable;

    protected static $factory;

    public static function useDefault()
    {
        static::$dateClass = null;
        static::$callable = null;
        static::$factory = null;
    }

    public static function useCallable(callable $callable)
    {
        static::$callable = $callable;

        static::$dateClass = null;
        static::$factory = null;
    }

    public static function useClass($dateClass)
    {
        static::$dateClass = $dateClass;

        static::$factory = null;
        static::$callable = null;
    }

    public static function useFactory($factory)
    {
        static::$factory = $factory;

        static::$dateClass = null;
        static::$callable = null;
    }

    public function __call($method, $parameters)
    {
        $defaultClassName = static::DEFAULT_CLASS_NAME;

        // Using callable to generate dates...
        if (static::$callable) {
            return call_user_func(static::$callable, $defaultClassName::$method(...$parameters));
        }

        // Using Carbon factory to generate dates...
        if (static::$factory) {
            return static::$factory->$method(...$parameters);
        }

        $dateClass = static::$dateClass ?: $defaultClassName;

        // Check if the date can be created using the public class method...
        if (method_exists($dateClass, $method) ||
            method_exists($dateClass, 'hasMacro') && $dateClass::hasMacro($method)) {
            return $dateClass::$method(...$parameters);
        }

        // If that fails, create the date with the default class...
        $date = $defaultClassName::$method(...$parameters);

        // If the configured class has an "instance" method, we'll try to pass our date into there...
        if (method_exists($dateClass, 'instance')) {
            return $dateClass::instance($date);
        }

        // Otherwise, assume the configured class has a DateTime compatible constructor...
        return new $dateClass($date->format('Y-m-d H:i:s.u'), $date->getTimezone());
    }
}