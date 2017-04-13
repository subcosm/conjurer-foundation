<?php
/**
 * This file is part of the subcosm.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Subcosm\Conjurer\Comparators;


use Subcosm\Conjurer\ConjurerApplicationContainerInterface;
use Subcosm\Conjurer\EnvironmentComparatorInterface;

class GlobalsComparator extends AbstractComparator implements EnvironmentComparatorInterface
{
    /**
     * @var array
     */
    protected $server = [];

    /**
     * @var array
     */
    protected $env = [];

    /**
     * @var array
     */
    protected $ini = [];

    /**
     * GlobalsComparator constructor.
     */
    public function __construct()
    {
        $this->server = $_SERVER;
        $this->env = $_ENV;
        $this->ini = ini_get_all();
    }

    /**
     * compares the SAPI of PHP.
     *
     * @param $value
     * @return bool
     */
    public function compareSAPI($value): bool
    {
        return PHP_SAPI === $value;
    }

    /**
     * compares environmental server api tokens.
     *
     * @param $value
     * @return bool
     */
    public function compareEnvironment($value): bool
    {
        if ( $value === 'cli' && PHP_SAPI === 'cli' ) {
            return true;
        }

        if ( $value === 'web' && PHP_SAPI !== 'cli' ) {
            return true;
        }

        return false;
    }

    /**
     * compares the operating system.
     *
     * @param $value
     * @return bool
     */
    public function compareOperatingSystem($value): bool
    {
        $value = strtolower($value);

        if ( $value === 'windows' && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ) {
            return true;
        }

        if ( $value === 'linux' && strtoupper(substr(PHP_OS, 0, 5)) === 'LINUX' ) {
            return true;
        }

        if ( $value === 'bsd' && false !== stripos(PHP_OS, 'bsd') ) {
            return true;
        }

        if ( $value === 'osx' && false !== stripos(PHP_OS, 'osx') ) {
            return true;
        }

        if ( $value === 'solaris' && false !== stripos(PHP_OS, 'solaris') ) {
            return true;
        }

        return false;
    }

    /**
     * compares the existence of the provided extension(s).
     *
     * @param $value
     * @return bool
     */
    public function comparePHPExtension($value)
    {
        if ( is_array($value) ) {
            foreach ( $value as $current ) {
                if ( ! extension_loaded($current) ) {
                    return false;
                }
            }

            return true;
        }

        return extension_loaded($value);
    }

    /**
     * compares the availability of a hash algorithm.
     *
     * @param $value
     * @return bool
     */
    public function compareHashAlgorithm($value)
    {
        return in_array($value, hash_algos());
    }

    /**
     * compares the minimum requirement of a provided PHP version.
     *
     * @param $value
     * @return mixed
     */
    public function comparePHPVersion($value)
    {
        return version_compare(PHP_VERSION, $value, '>=');
    }

    /**
     * compares if the provided php settings do match.
     *
     * @param $value
     * @return bool
     */
    public function comparePHPSettings($value)
    {
        if ( ! is_array($value) ) {
            throw new \InvalidArgumentException('Comparator value must be an array');
        }

        foreach ( $value as $key => $setting ) {
            if ( ! array_key_exists($key, $this->ini) ) {
                return false;
            }

            if ( array_key_exists($key, $this->ini) && $this->ini[$key] ==! $setting ) {
                return false;
            }
        }

        return true;
    }

    /**
     * compares if the debug value does resolve to the same boolean.
     *
     * @param $value
     * @param ConjurerApplicationContainerInterface $container
     * @return bool
     */
    public function compareDebugValue($value, ConjurerApplicationContainerInterface $container)
    {
        if ( ! $container->has('~debug') ) {
            return false;
        }

        $debug = filter_var($container->get('~debug'), FILTER_VALIDATE_BOOLEAN);

        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);

        return $debug === $value;
    }

    /**
     * returns the list of scope setting keys associated to their method names.
     *
     * @return array
     */
    public function getCallbacks(): array
    {
        return [
            'server-api'                => 'compareSAPI',
            'sapi'                      => 'compareSAPI',
            'env'                       => 'compareEnvironment',
            'environment'               => 'compareEnvironment',
            'operating-system-family'   => 'compareOperatingSystem',
            'os-family'                 => 'compareOperatingSystem',
            'extension'                 => 'comparePHPExtension',
            'hash-algorithm'            => 'compareHashAlgorithm',
            'php-version'               => 'comparePHPVersion',
            'php'                       => 'comparePHPVersion',
            'php-settings'              => 'comparePHPSettings',
            'php.ini'                   => 'comparePHPSettings',
            'debug'                     => 'compareDebugValue',
        ];
    }
}