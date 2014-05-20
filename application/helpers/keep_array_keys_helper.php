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

if ( ! function_exists('keep_array_keys')) {

    /**
     * Keep only the desired keys in a hash
     * @param array $arr The array hash with all the data including any bad keys
     * @param array $keys The keys we want to keep
     * @return array Hash with only the keys we want to keep
     */
    function keep_array_keys(array $arr, array $keys)
    {
        foreach ($arr as $key => $value) {
            if( ! in_array($key, $keys))
                unset($arr[$key]);
        }
        return $arr;
    }

}
