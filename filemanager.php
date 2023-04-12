<?php
define('security', TRUE); // Add light protection against file access

// Folder for file manager
define('MANAGERFOLDER', 'filemanager/');

// Connect the config file
include MANAGERFOLDER.'config.php';

// Connect the base controller
include MANAGERFOLDER.'baseController.php';


/**
 * View html
 */

// HTML head
include setPath('view').'system--head.php';

// Switch the page
include setPath('view').'page--'.$systemOption['page'].'.php';

// HTML footer
include setPath('view').'system--footer.php';