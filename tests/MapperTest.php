<?php

namespace App\Tests;

use App\Model\Airbnb\Room;
use AutoMapper\AutoMapperInterface;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Database;
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
            '_id' => '10009999',
        ], [
            'typeMap' => ['root' => 'array', 'array' => 'array', 'object' => 'array'],
        ]);

        foreach ($results as $result) {
            $room = $mapper->map($result, Room::class);
            dd($room);
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