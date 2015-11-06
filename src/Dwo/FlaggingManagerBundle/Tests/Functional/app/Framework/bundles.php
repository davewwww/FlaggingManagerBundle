<?php

use Dwo\ConfigPrototypeBundle\DwoConfigPrototypeBundle;
use Dwo\FlaggingBundle\DwoFlaggingBundle;
use Dwo\FlaggingManagerBundle\DwoFlaggingManagerBundle;

return array(
    new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
    new Symfony\Bundle\TwigBundle\TwigBundle(),
    #new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
    #new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),

    new DwoConfigPrototypeBundle(),
    new DwoFlaggingBundle(),
    new DwoFlaggingManagerBundle(),

    new Symfony\Bundle\FrameworkBundle\Tests\Functional\Bundle\TestBundle\TestBundle(),
);
