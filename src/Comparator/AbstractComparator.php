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

abstract class AbstractComparator implements EnvironmentComparatorInterface
{
    /**
     * returns the list of scope setting keys associated to their method names.
     *
     * @return array
     */
    abstract public function getCallbacks(): array;

    /**
     * compares the environment to the provided scope settings.
     *
     * @param array $scope
     * @param ConjurerApplicationContainerInterface $container
     * @return bool
     */
    public function compareTo(array $scope, ConjurerApplicationContainerInterface $container): bool
    {
        $callbacks = $this->getCallbacks();

        foreach ( $scope as $scopeKey => $scopeValue ) {
            if ( ! array_key_exists($scopeKey, $callbacks) ) {
                return false;
            }

            $result = call_user_func([$this, $callbacks[$scopeKey]], $scopeValue, $container);

            if ( ! $result ) {
                return false;
            }
        }

        return true;
    }
}
