<?php

namespace App\services;

class Pagination
{

    public static function paginate($page,$service, $redirect, $limit)
    {
        $limit = $limit;
        $allItems = $service;
        $numberOfItems = \count($allItems);

        $currentPage = $page ?? 1;
        $offset = ($currentPage - 1) * $limit;

        $totalPages = ceil($numberOfItems / $limit);

        if ($currentPage > $totalPages || $currentPage <= 0) {
            \header("location: $redirect");
            return;
        }

        $itemsPerPage = \array_slice($allItems, $offset, $limit);

        return [
            $itemsPerPage,
            $currentPage,
            $totalPages
        ];
    }
}
