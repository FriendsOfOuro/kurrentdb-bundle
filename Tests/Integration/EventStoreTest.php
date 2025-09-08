<?php

namespace EventStore\Bundle\ClientBundle\Tests\Integration;

use EventStore\Bundle\ClientBundle\DependencyInjection\EventStoreClientExtension;
use EventStore\EventStore;
use EventStore\Exception\StreamDeletedException;
use EventStore\Exception\StreamNotFoundException;
use EventStore\Exception\WrongExpectedVersionException;
use EventStore\WritableEvent;
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

        return $builder->get('event_store_client.event_store');
    }
}
