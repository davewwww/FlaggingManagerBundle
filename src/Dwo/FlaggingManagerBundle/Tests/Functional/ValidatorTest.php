<?php

namespace Dwo\FlaggingManagerBundle\Tests\Functional;

use Dwo\FlaggingManager\Model\Feature;
use Dwo\FlaggingManagerBundle\Tests\DependencyInjection;
use Dwo\FlaggingManagerBundle\Tests\Functional\app\AppKernel;
use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ValidatorInterface
     */
    protected static $validator;

    /**
     * @beforeClass
     */
    public static function init()
    {
        $kernel = new AppKernel('Framework', 'config.yml', 'test', true);
        $kernel->boot();

        self::$validator = $kernel->getContainer()->get('validator');
    }

    /**
     * @dataProvider featureProvider
     */
    public function testGetVoter($content, $error)
    {
        $form = new Feature();
        $form->setName('');
        $form->setContent($content);

        $violations = self::$validator->validate($form);

        $result = $violations->has(0) ? (string) $violations->get(0)->getMessage() : null;
        if (null === $error) {
            self::assertNull($error, $result);
        } else {
            self::assertContains($error, $result);
        }
    }

    public function featureProvider()
    {
        return array(
            array([], null),
            array(Yaml::parse('filters: [{name:[123]}]'), null),
            array(Yaml::parse('filters: [{foo:[123]}]'), 'unknown voter "foo"'),
            array(Yaml::parse('filters: [foo]'), 'Invalid type for path'),
        );
    }
}