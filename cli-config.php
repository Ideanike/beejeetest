<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once 'src/bootstrap/db.php';

return ConsoleRunner::createHelperSet($entityManager);
