<?php

/**
 * Data file for timezone "Pacific/Port_Moresby".
 * Compiled from olson file "australasia", version 8.20.
 *
 * @package    agavi
 * @subpackage translation
 *
 * @copyright  Authors
 * @copyright  The Agavi Project
 *
 * @since      0.11.0
 *
 * @version    $Id: Pacific_47_Port_Moresby.php 4590 2010-12-07 08:11:19Z david $
 */

return array (
  'types' => 
  array (
    0 => 
    array (
      'rawOffset' => 35312,
      'dstOffset' => 0,
      'name' => 'PMMT',
    ),
    1 => 
    array (
      'rawOffset' => 36000,
      'dstOffset' => 0,
      'name' => 'PGT',
    ),
  ),
  'rules' => 
  array (
    0 => 
    array (
      'time' => -2840176120,
      'type' => 0,
    ),
    1 => 
    array (
      'time' => -2366790512,
      'type' => 1,
    ),
  ),
  'finalRule' => 
  array (
    'type' => 'static',
    'name' => 'PGT',
    'offset' => 36000,
    'startYear' => 1895,
  ),
  'source' => 'australasia',
  'version' => '8.20',
  'name' => 'Pacific/Port_Moresby',
);

?>