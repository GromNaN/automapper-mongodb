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
use MongoDB\BSON\Decimal128;
use MongoDB\BSON\Int64;
use Symfony\Component\PropertyInfo\Type;

final class BSONToFloatTransformer implements PropertyTransformerInterface, PropertyTransformerSupportInterface, PrioritizedPropertyTransformerInterface
{
    public function transform(mixed $value, object|array $source, array $context): float
    {
        if ($value instanceof Decimal128 || $value instanceof Int64) {
            return intval($value->serialize());
        } elseif (is_numeric($value)) {
            return (float) $value;
        }

        throw new \InvalidArgumentException(sprintf('Unexpected "int" type, got "%s"', get_debug_type($value)));
    }

    public function supports(TypesMatching $types, SourcePropertyMetadata $source, TargetPropertyMetadata $target, MapperMetadata $mapperMetadata): bool
    {
        $sourceType = $types->getSourceUniqueType();

        if (!$sourceType) {
            return false;
        }

        // Transforms only to "float"
        if (Type::BUILTIN_TYPE_FLOAT !== $types->getTargetUniqueType($sourceType)?->getBuiltinType()) {
            return false;
        }

        // Convert numeric BSON types
        if (in_array($sourceType->getClassName(), [Int64::class, Decimal128::class])) {
            return true;
        }

        // The target type is used for generic array and stdClass
        if (Type::BUILTIN_TYPE_FLOAT === $sourceType->getBuiltinType()) {
            return true;
        }

        return false;
    }

    public function getPriority(): int
    {
        return 100;
    }
}
