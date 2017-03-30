<?php
require_once 'globals.php';

use model\orm\ORM;

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(ORM::getManager());