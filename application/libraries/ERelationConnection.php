<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *
 * Copyright 2014 Medical Research Council Harwell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

/**
 * With the introduction of the functionality to create a relationship between
 * two seperate procedures/parameters without having to create a new version of
 * the item, there came a need to describe how this relation was formed and how
 * these two items are connected - either by creating a new version or 
 * "RELATION" or some arbitrary connection by "ASSOCIATION"
 */
class ERelationConnection
{
    const RELATION    = 'RELATION';
    const ASSOCIATION = 'ASSOCIATION';

    /**
     * @return string default value of RELATION
     */
    public function __toString()
    {
        return self::RELATION;
    }

    /**
     * @return array
     */
    public static function __toArray()
    {
        return array(
            self::RELATION,
            self::ASSOCIATION
        );
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function validate($value = '')
    {
        return in_array($value, self::__toArray());
    }
}
