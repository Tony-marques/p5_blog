<?php

namespace App\Services;

class Pagination
{
    public static function paginate(?string $page,array|object $service, string $redirect, int $limit): null|array
    {
        $limit = $limit;
        $allItems = $service;
        $numberOfItems = \count($allItems);

        $currentPage = $page ?? 1;
        $offset = ($currentPage - 1) * $limit;

        $totalPages = ceil($numberOfItems / $limit);

        if ($currentPage > $totalPages || $currentPage <= 0) {
            \header("location: $redirect");
            return null;
        }

        $itemsPerPage = \array_slice($allItems, $offset, $limit);

        return [
            $itemsPerPage,
            $currentPage,
            $totalPages
        ];
    }
}
