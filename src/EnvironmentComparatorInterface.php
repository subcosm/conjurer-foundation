<?php
/**
 * This file is part of the subcosm.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Subcosm\Conjurer;


interface EnvironmentComparatorInterface
{
    /**
     * compares the environment to the provided scope settings.
     *
     * @param array $scope
     * @param ConjurerApplicationContainerInterface $container
     * @return bool
     */
    public function compareTo(array $scope, ConjurerApplicationContainerInterface $container): bool;
}