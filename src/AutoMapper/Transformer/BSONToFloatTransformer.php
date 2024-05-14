<?php

declare(strict_types=1);

namespace App\AutoMapper\Transformer;

use AutoMapper\Metadata\MapperMetadata;
use AutoMapper\Metadata\SourcePropertyMetadata;
use AutoMapper\Metadata\TargetPropertyMetadata;
use AutoMapper\Metadata\TypesMatching;
use AutoMapper\Transformer\PropertyTransformer\PropertyTransformerInterface;
use AutoMapper\Transformer\PropertyTransformer\PropertyTransformerSupportInterface;
use MongoDB\BSON\Decimal128;

final class BSONToFloatTransformer implements PropertyTransformerInterface, PropertyTransformerSupportInterface // , TransformerFactoryInterface
{
    public function transform(mixed $value, object|array $source, array $context): float
    {
        assert($value instanceof Decimal128);

        return floatval($value->serialize());
    }

    public function supports(TypesMatching $types, SourcePropertyMetadata $source, TargetPropertyMetadata $target, MapperMetadata $mapperMetadata): bool
    {
        $sourceUniqueType = $types->getSourceUniqueType();

        if (null === $sourceUniqueType) {
            return false;
        }

        return Decimal128::class === $sourceUniqueType->getClassName();
    }

    public function getTransformer(TypesMatching $types, SourcePropertyMetadata $source, TargetPropertyMetadata $target, MapperMetadata $mapperMetadata): ?TransformerInterface
    {
        // TODO: Implement getTransformer() method.
    }
}
