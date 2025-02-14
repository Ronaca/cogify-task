<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Book;
use Symfony\Component\HttpFoundation\Response;

class BookApiTest extends ApiTestCase
{
    private string $apiUrl = '/api/books'; // Adjust this based on your API URL

    public function testGetBooks()
    {
        // Create a client to send requests
        $client = self::createClient();

        // Make a GET request to fetch the books
        $client->request('GET', $this->apiUrl);

        // Assert that the response is OK (status code 200)
        $this->assertResponseIsSuccessful();

        // You can also assert that the response contains expected data
        // If you want to test that your API returns a collection, you can assert the number of items
        $this->assertJsonContains([
            '@context' => '/api/contexts/Book',
        ]);
    }

    public function testPostBook()
    {
        // Create a client to send requests
        $client = self::createClient();

        // Prepare data for creating a new book
        $data = [
            'isbn' => '1234567890', // Adjust this based on your Book entity's fields, e.g., 'isbn
            'title' => 'New Book Title',
            'author' => 'Some Author',
            'publishedYear' => 2020,
            'genre' => 'Fiction',
        ];

        // Send a POST request to create a new book
        $client->request('POST', $this->apiUrl, [
            'json' => $data, // Pass the data as JSON body
            'headers' => [
                'Content-Type' => 'application/json', // Set the Content-Type header to JSON
            ],
        ]);

        // Assert that the response is successful (status code 201)
        $this->assertResponseStatusCodeSame(201);

        // Check the response content to ensure it matches the data you just posted
        $this->assertJsonContains($data);
    }

    public function testPutBook(): void
    {
        // Assuming you have an existing book to update
        $bookIsbn = '1234567890'; // Replace with actual ID from your DB
        $client = static::createClient();

        $data = [
            'title' => 'Updated Book Title',
        ];

        $client->request('PUT', "/api/books/{$bookIsbn}", ['json' => $data]);

        // Assert that the response is successful (status code 200)
        $this->assertResponseStatusCodeSame(200);

        $this->assertJsonContains([
            'title' => 'Updated Book Title',
        ]);  // Check if the response contains the updated title
    }

    public function testDeleteBook(): void
    {
        // Assuming you have an existing book to delete
        $bookIsbn = '1234567890'; // Replace with actual ID from your DB
        $client = static::createClient();

        $client->request('DELETE', "/api/books/{$bookIsbn}");
        $this->assertResponseStatusCodeSame(204);

        // Assert that the book is deleted
        $client->request('GET', '/api/books/' . $bookIsbn);
        $this->assertResponseStatusCodeSame(404);  // Book should no longer exist

    }

}
