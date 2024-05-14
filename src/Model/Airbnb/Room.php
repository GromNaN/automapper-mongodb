<?php

namespace App\Model\Airbnb;

use App\AutoMapper\Transformer\BSONToDateTimeTransformer;
use App\AutoMapper\Transformer\BSONToFloatTransformer;
use App\AutoMapper\Transformer\BSONToIntTransformer;
use AutoMapper\Attribute\MapFrom;
use AutoMapper\Attribute\MapTo;

class Room
{
    public string $id;

    public string $listing_url;
    public string $name;
    public string $summary;
    public string $space;
    public string $description;
    public string $neighborhood_overview;
    public string $notes;
    public string $transit;
    public string $access;
    public string $interaction;
    public string $house_rules;
    public string $property_type; // Enum ?
    public string $room_type; // Enum ?
    public string $bed_type; // Enum ?
    public int $minimum_nights;
    public string $maximum_nights;
    public string $cancellation_policy; // Enum
    #[MapFrom(transformer: BSONToDateTimeTransformer::class)]
    public \DateTimeImmutable $last_scraped;
    #[MapFrom(transformer: BSONToDateTimeTransformer::class)]
    public \DateTimeImmutable $calendar_last_scraped;
    #[MapFrom(transformer: BSONToDateTimeTransformer::class)]
    public \DateTimeImmutable $first_review;
    #[MapFrom(transformer: BSONToDateTimeTransformer::class)]
    public \DateTimeImmutable $last_review;
    public int $accommodates;
    public int $bedrooms;
    public int $beds;
    public int $number_of_reviews;

    #[MapFrom(transformer: BSONToIntTransformer::class)]
    public int $bathrooms;
    /** @var string[] */
    public array $amenities;
    #[MapFrom(transformer: BSONToFloatTransformer::class)]
    public float $price; // Currency
    public float $security_deposit; // Currency
    #[MapFrom(transformer: BSONToFloatTransformer::class)]
    public float $cleaning_fee;
    #[MapFrom(transformer: BSONToFloatTransformer::class)]
    public float $extra_people;
    #[MapFrom(transformer: BSONToIntTransformer::class)]
    public int $guests_included;
    public array $images; // Image objects
    public object $host;
    public object $address;
    public object $availability;
    public object $review_scores;
    public array $reviews;
}