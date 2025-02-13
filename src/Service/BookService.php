<?php

namespace App\Service;

class BookService
{
    public function calculateAge(int $publishedYear): int
    {
        $currentYear = (int) date('Y');
        return max(0, $currentYear - $publishedYear); // Prevent negative ages
    }
}
