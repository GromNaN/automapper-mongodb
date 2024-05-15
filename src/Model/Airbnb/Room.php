<?php

namespace App\Model\Airbnb;

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
    public \DateTimeImmutable $last_scraped;
    public \DateTimeImmutable $calendar_last_scraped;
    public \DateTimeImmutable $first_review;
    public \DateTimeImmutable $last_review;
    public int $accommodates;
    public int $bedrooms;
    public int $beds;
    public int $number_of_reviews;

    public int $bathrooms;
    /** @var string[] */
    public array $amenities;
    public float $price; // Currency
    public float $security_deposit; // Currency
    public float $cleaning_fee;
    public float $extra_people;
    public int $guests_included;
    public array $images; // Image objects
    public object $host;
    public object $address;
    public object $availability;
    public object $review_scores;
    public array $reviews;
}
