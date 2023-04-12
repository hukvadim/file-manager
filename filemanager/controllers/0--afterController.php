<?php
defined('security') or die('Access denied'); // Add light protection against file access

// Add css class to the html body tag
$systemOption['bodyCssClass'][] = 'page-'.$systemOption['page'];

// Add another part to the header for beauty
$seo['title'] = $seo['title'].' '.setLang('titlePart');