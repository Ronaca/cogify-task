<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Book;
use Symfony\Component\HttpFoundation\Response;

class BookApiTest extends ApiTestCase
{
    private string $apiUrl = '/api/books'; // Adjust this based on your API URL

    public function testPostBook(): void
    {
        $client = self::createClient();

        $data = [
            'isbn' => '123456789004',
            'title' => 'New Book Title',
            'author' => 'Some Author',
            'publishedYear' => 2020,
            'genre' => 'Fiction',
        ];

        // Send a POST request
        $client->request('POST', $this->apiUrl, [
            'json' => $data,
        ]);

        // Assert that the response is successful (status code 201)
        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Assert the response contains the posted data
        $this->assertJsonContains($data);
    }

    public function testGetBooks(): void
    {
        $client = self::createClient();

        // Make a GET request to fetch the books
        $client->request('GET', $this->apiUrl);

        // Assert that the response is OK (status code 200)
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Check if the response contains expected data
        $this->assertJsonContains([
            '@context' => '/api/contexts/Book',
        ]);
    }

    public function testGetBook(): void
    {
        $client = self::createClient();

        $isbn = '123456789004';

        // Make a GET request for the book
        $client->request('GET', $this->apiUrl."/{$isbn}");

        // Assert that the response is successful (status code 200)
        $this->assertResponseIsSuccessful(200);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Assert that the response contains the book data
        $this->assertJsonContains([
            'isbn' => $isbn,
        ]);
    }

    public function testUpdateBook(): void
    {
        $client = self::createClient();

        $isbn = '123456789004';

        $data = [
            'title' => 'Updated Book Title',
            'author' => 'Updated Author',
            'publishedYear' => 2021,
            'genre' => 'Non-Fiction',
        ];

        // Send a PATCH request
        $client->request('PATCH', $this->apiUrl."/{$isbn}", [
            'json' => $data,
            'headers' => ['Content-Type' => 'application/merge-patch+json']
        ]);

        // Assert that the response is successful (status code 200)
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Assert the response contains the updated data
        $this->assertJsonContains($data);
    }

    public function testDeleteBook(): void
    {
        $client = self::createClient();

        $isbn = '123456789004';

        // Perform DELETE request
        $client->request('DELETE', $this->apiUrl."/{$isbn}");
        $this->assertResponseStatusCodeSame(204);

        // Assert that the book is deleted
        $client->request('GET', $this->apiUrl."/{$isbn}");
        $this->assertResponseStatusCodeSame(404);
    }
}
