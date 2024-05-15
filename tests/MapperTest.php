<?php

namespace App\Tests;

use App\Model\Airbnb\Room;
use AutoMapper\AutoMapperInterface;
use MongoDB\Client;
use MongoDB\Collection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MapperTest extends KernelTestCase
{
    public function testMap()
    {
        $mapper = $this->getAutoMapper();
        $collection = $this->getCollection('sample_airbnb', 'listingsAndReviews');
        $this->assertNotNull($mapper);
        $this->assertNotNull($collection);

        $results = $collection->find([
            // '_id' => '10009999',
        ], [
            'typeMap' => ['root' => 'array', 'array' => 'array', 'object' => 'array'],
            // 'typeMap' => ['root' => 'bson', 'array' => 'bson', 'object' => 'bson'],
            'limit' => 2,
        ]);

        foreach ($results as $result) {
            $room = $mapper->map($result, Room::class);
            dump($room);
            $this->assertTrue(isset($room->calendar_last_scraped));
        }
    }

    private function getAutoMapper(): AutoMapperInterface
    {
        return self::getContainer()->get(AutoMapperInterface::class);
    }

    private function getCollection(string $database, string $collection): Collection
    {
        return self::getContainer()->get(Client::class)->selectDatabase($database)->selectCollection($collection);
    }
}
