<?php
namespace App\Tests\Service;

use App\Service\BookService;
use PHPUnit\Framework\TestCase;

class BookServiceTest extends TestCase
{
    public function testCalculateAge()
    {
        // Create an instance of the BookService
        $bookService = new BookService();

        // Get the current year
        $thisYear = (int) date('Y');

        // Test with a book published this year
        $this->assertSame(0, $bookService->calculateAge($thisYear));

        // Test with a book published 10 years ago
        $this->assertSame(10, $bookService->calculateAge($thisYear - 10));

        // Test with a book from 100 years ago
        $this->assertSame(100, $bookService->calculateAge($thisYear - 100));

        // Test with a book from the future (should return 0)
        $this->assertSame(0, $bookService->calculateAge($thisYear + 5));
    }
}
