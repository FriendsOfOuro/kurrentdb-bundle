<?php

namespace KurrentDB\Bundle\ClientBundle\Tests\Integration;

use KurrentDB\Bundle\ClientBundle\DependencyInjection\EventStoreClientExtension;
use KurrentDB\EventStore;
use KurrentDB\Exception\StreamDeletedException;
use KurrentDB\Exception\StreamNotFoundException;
use KurrentDB\Exception\WrongExpectedVersionException;
use KurrentDB\WritableEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EventStoreTest extends TestCase
{
    /**
     * @throws WrongExpectedVersionException
     * @throws StreamNotFoundException
     * @throws StreamDeletedException
     * @throws \Exception
     */
    public function testEventStoreCanCreateAStreamAndOpenIt(): void
    {
        $es = $this->getEventStore();

        $event = WritableEvent::newInstance('SomethingHappened', ['foo' => 'bar']);
        $streamName = 'StreamName';

        $es->writeToStream($streamName, $event);
        $es->openStreamFeed($streamName);

        $this->expectNotToPerformAssertions();
    }

    /**
     * @throws \Exception
     */
    private function getEventStore(): EventStore
    {
        $loader = new EventStoreClientExtension();

        $builder = new ContainerBuilder();
        $loader->load([], $builder);

        return $builder->get('kurrent_db_client.event_store');
    }
}
