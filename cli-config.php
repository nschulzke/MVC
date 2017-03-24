<?php
require_once __DIR__ . "/class/model/orm/bootstrap.php";
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);