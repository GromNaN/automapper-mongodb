<?php

declare(strict_types=1);

namespace App\AutoMapper\Transformer;

use AutoMapper\Metadata\MapperMetadata;
use AutoMapper\Metadata\SourcePropertyMetadata;
use AutoMapper\Metadata\TargetPropertyMetadata;
use AutoMapper\Metadata\TypesMatching;
use AutoMapper\Transformer\PropertyTransformer\PrioritizedPropertyTransformerInterface;
use AutoMapper\Transformer\PropertyTransformer\PropertyTransformerInterface;
use AutoMapper\Transformer\PropertyTransformer\PropertyTransformerSupportInterface;
use MongoDB\BSON\UTCDateTime;
use Symfony\Component\PropertyInfo\Type;

final class BSONToDateTimeImmutableTransformer implements PropertyTransformerInterface, PropertyTransformerSupportInterface, PrioritizedPropertyTransformerInterface
{
    public function transform(mixed $value, object|array $source, array $context): \DateTimeImmutable
    {
        if ($value instanceof UTCDateTime) {
            return \DateTimeImmutable::createFromInterface($value->toDateTime());
        }

        throw new \InvalidArgumentException(sprintf('Unexpected "UTCDateTime" type, got "%s"', get_debug_type($value)));
    }

    public function supports(TypesMatching $types, SourcePropertyMetadata $source, TargetPropertyMetadata $target, MapperMetadata $mapperMetadata): bool
    {
        $targetClass = $types->getTargetUniqueType($types->getSourceUniqueType())?->getClassName();

        if (!$targetClass) {
            return false;
        }

        // Transforms only to "DateTimeInterface" or "DateTimeImmutable" subclasses
        if (\DateTimeInterface::class !== $targetClass
            && \DateTimeImmutable::class !== $targetClass
            && !is_subclass_of($targetClass, \DateTimeImmutable::class)) {
            return false;
        }

        // Convert numeric BSON types
        if (UTCDateTime::class === $types->getSourceUniqueType()?->getClassName()) {
            return true;
        }

        // The "string" is used for generic array and stdClass
        if (Type::BUILTIN_TYPE_STRING === $types->getSourceUniqueType()?->getBuiltinType()) {
            return true;
        }

        return false;
    }

    public function getPriority(): int
    {
        return 100;
    }
}
