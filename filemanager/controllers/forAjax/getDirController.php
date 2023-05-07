<?php
defined('security') or die('Access denied'); // Add light protection against file access

$result['list'] = 'YES!!!';

// Encode result for ajax response
exit( json_encode($result) );
