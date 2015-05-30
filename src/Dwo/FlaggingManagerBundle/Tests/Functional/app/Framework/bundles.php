<?php

use Dwo\ConfigPrototypeBundle\DwoConfigPrototypeBundle;
use Dwo\FlaggingBundle\DwoFlaggingBundle;
use Dwo\FlaggingManagerBundle\DwoFlaggingManagerBundle;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\Bundle\TestBundle\TestBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;

return array(
    new FrameworkBundle(),
    new DwoConfigPrototypeBundle(),
    new DwoFlaggingBundle(),
    new DwoFlaggingManagerBundle(),
    #new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
    #new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
    new TestBundle(),
);
