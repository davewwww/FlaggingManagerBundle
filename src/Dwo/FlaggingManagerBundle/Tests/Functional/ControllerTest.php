<?php

namespace Dwo\FlaggingManagerBundle\Tests\Functional;

use Dwo\FlaggingManagerBundle\Tests\Functional\app\AppKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DomCrawler\Crawler;

class ControllerTest extends WebTestCase
{
    public function test()
    {
        $kernel = new AppKernel('Framework', 'config.yml', 'test', true);
        $kernel->boot();

        /** @var ContainerInterface $c */
        $c = $kernel->getContainer();
        $client = $c->get('test.client');

        /** @var Crawler $crawler */
        $crawler = $client->request('GET', '/features/test_feature');

        self::assertContains('test_feature', $crawler->html());
    }

}
