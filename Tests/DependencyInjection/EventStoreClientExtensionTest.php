<?php
namespace EventStore\Bundle\ClientBundle\Tests\DependencyInjection;

/**
 * Some methods are from FOSUserBundle (Copyright (c) 2010-2011 FriendsOfSymfony)
 * @author Davide Bellettini <davide@bellettini.me>>
 */

use EventStore\Bundle\ClientBundle\DependencyInjection\EventStoreClientExtension;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

class EventStoreClientExtensionTest extends TestCase
{
    public function testBaseUrlIsPopulatedCorrectlyByDefault()
    {
        $loader = new EventStoreClientExtension();
        $config = $this->getConfig();
        unset($config['base_url']);

        $builder = new ContainerBuilder();
        $loader->load([$config], $builder);

        $this->assertEquals('http://127.0.0.1:2113/', $builder->getParameter('event_store_client.base_url'));
    }

    public function testBaseUrlIsPopulatedCorrectlyFromConfiguration()
    {
        $loader = new EventStoreClientExtension();
        $config = $this->getConfig();

        $builder = new ContainerBuilder();
        $loader->load([$config], $builder);

        $this->assertEquals('http://eventstore-fake.com:2113/', $builder->getParameter('event_store_client.base_url'));
    }

    public function testItShouldCreateEventStoreClientProperly()
    {
        $loader = new EventStoreClientExtension();
        $config = $this->getConfig();
        $config['base_url'] = 'http://127.0.0.1:2113/';

        $builder = new ContainerBuilder();
        $loader->load([$config], $builder);
        $builder->compile();

        $this->assertInstanceOf('EventStore\EventStore', $builder->get('event_store_client.event_store'));
    }

    private function getConfig()
    {
        $yaml = <<<EOF
base_url: http://eventstore-fake.com:2113/
EOF;

        return (new Parser())->parse($yaml);
    }
}
