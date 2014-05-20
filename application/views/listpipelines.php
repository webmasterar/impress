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
* @param array $pipelines A RecordSet (row array) from the pipeline table
* @param string $controller controller
*/

$deprecatedTitleDisplayed = false;

foreach($pipelines AS $p){
    if ( ! should_display($p))
        continue;
    
    if ($p->isDeprecated() && false === $deprecatedTitleDisplayed) {
        echo "<h2 class='legacytitle'><a name='legacy'>Legacy Pipelines</a></h2>\n";
        $deprecatedTitleDisplayed = true;
    }

    echo "<h3>" . anchor('procedures/' . $p->getId(), e($p->getItemName()))
       , " <span class='pipelinekey dark'>" . $p->getItemKey() . "</span></h3>\n"
       , "<p>" . e(strip_tags($p->getDescription())) . "</p>\n";
}
