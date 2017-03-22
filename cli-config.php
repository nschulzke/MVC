<?php
require_once __DIR__ . "/model/orm/bootstrap.php";
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);