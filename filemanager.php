<?php
define('security', TRUE); // Add light protection against file access

// Connect the config file
include 'filemanager/config.php';

print_arr($_SERVER); exit;

// If the ajax request
if ($_SERVER['REQUEST_METHOD'] === 'POST')
    include MANAGERFOLDER.'ajax.php';

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