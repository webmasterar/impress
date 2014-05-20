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
 * @param Procedure[]|Parameter[] $insertedItems Either a Procedure or a Parameter array
 */
?>

<h3>Items Inserted</h3>

<?php
if (empty($insertedItems)):
?>

<p>You did not select any items to import. Please go back and try again.</p>

<?php
else:
?>

<p>The following Items... </p>

<p>
<?php
foreach ($insertedItems AS $p) {
    echo '(', $p->getId(), ') ', e($p->getItemName()), ' [', $p->getItemKey(), ']<br>';
}
?>
<br>...were inserted into your Pipeline/Procedure.
</p>

<?php
endif;
