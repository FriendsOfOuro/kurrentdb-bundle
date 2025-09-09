<?php

namespace KurrentDB\Bundle\ClientBundle\Tests\DependencyInjection;

/*
 * Some methods are from FOSUserBundle (Copyright (c) 2010-2011 FriendsOfSymfony)
 * @author Davide Bellettini <davide@bellettini.me>>
 */

use KurrentDB\Bundle\ClientBundle\DependencyInjection\EventStoreClientExtension;
use KurrentDB\EventStore;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

class EventStoreClientExtensionTest extends TestCase
{
    public function testBaseUrlIsPopulatedCorrectlyByDefault(): void
    {
        $loader = new EventStoreClientExtension();
        $config = $this->getConfig();
        unset($config['base_url']);

        $builder = new ContainerBuilder();
        $loader->load([$config], $builder);

        $this->assertEquals('http://127.0.0.1:2113', $builder->getParameter('kurrent_db_client.base_url'));
    }

    public function testBaseUrlIsPopulatedCorrectlyFromConfiguration(): void
    {
        $loader = new EventStoreClientExtension();
        $config = $this->getConfig();

        $builder = new ContainerBuilder();
        $loader->load([$config], $builder);

        $this->assertEquals('http://eventstore-fake.com:2113', $builder->getParameter('kurrent_db_client.base_url'));
    }

    public function testItShouldCreateEventStoreClientProperly(): void
    {
        $loader = new EventStoreClientExtension();
        $config = $this->getConfig();
        $config['base_url'] = 'http://127.0.0.1:2113';

        $builder = new ContainerBuilder();
        $loader->load([$config], $builder);
        $builder->compile();

        $this->assertInstanceOf(EventStore::class, $builder->get('kurrent_db_client.event_store'));
    }

    private function getConfig(): mixed
    {
        $yaml = <<<EOF
base_url: http://eventstore-fake.com:2113
EOF;

        return new Parser()->parse($yaml);
    }
}
