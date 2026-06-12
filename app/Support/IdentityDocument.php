<?php

namespace App\Support;

class IdentityDocument
{
    public static function normalize(?string $value): string
    {
        return preg_replace('/\D+/', '', trim((string) $value)) ?? '';
    }

    public static function canonicalize(?string $value): string
    {
        $normalized = static::normalize($value);

        if (strlen($normalized) === 13 && str_ends_with($normalized, '001')) {
            return substr($normalized, 0, 10);
        }

        return $normalized;
    }

    public static function equivalentIdentifiers(?string $value): array
    {
        $normalized = static::normalize($value);

        if ($normalized === '') {
            return [];
        }

        $canonical = static::canonicalize($normalized);
        $variants = [$normalized, $canonical];

        if (strlen($canonical) === 10) {
            $variants[] = $canonical.'001';
        }

        if (strlen($normalized) === 13 && str_ends_with($normalized, '001')) {
            $variants[] = substr($normalized, 0, 10);
        }

        return array_values(array_unique(array_filter($variants)));
    }

    public static function fullName(?string $nombres, ?string $apellidos): string
    {
        return trim(trim((string) $nombres).' '.trim((string) $apellidos));
    }

    public static function splitFullName(?string $name): array
    {
        $parts = preg_split('/\s+/', trim((string) $name)) ?: [];
        $parts = array_values(array_filter($parts, fn ($part) => $part !== ''));
        $count = count($parts);

        if ($count === 0) {
            return ['', ''];
        }

        if ($count === 1) {
            return [$parts[0], ''];
        }

        $middle = (int) ceil($count / 2);

        return [
            implode(' ', array_slice($parts, 0, $middle)),
            implode(' ', array_slice($parts, $middle)),
        ];
    }
}
