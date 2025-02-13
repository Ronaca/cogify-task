<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/books', name: 'book_')]
class BookController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // 1. List all books
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $books = $this->entityManager->getRepository(Book::class)->findAll();

        return $this->json($books);
    }

    // 2. Get a book by ISBN
    #[Route('/isbn/{isbn}', name: 'get_by_isbn', methods: ['GET'])]
    public function getByIsbn(string $isbn): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            return $this->json(['message' => 'Book not found'], 404);
        }

        return $this->json($book);
    }

    // 3. Add a new book
    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate required fields
        if (!isset($data['isbn'], $data['title'], $data['author'], $data['publishedYear'], $data['genre'])) {
            return $this->json(['message' => 'Missing required fields'], 400);
        }

        // Check if ISBN already exists
        if ($this->entityManager->getRepository(Book::class)->findOneBy(['isbn' => $data['isbn']])) {
            return $this->json(['message' => 'A book with this ISBN already exists'], 409);
        }

        $book = new Book();
        $book->setIsbn($data['isbn'])
            ->setTitle($data['title'])
            ->setAuthor($data['author'])
            ->setPublishedYear($data['publishedYear'])
            ->setGenre($data['genre']);

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $this->json($book, 201);
    }

    // 4. Update an existing book (by ID)
    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['message' => 'Book not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        // Update fields if provided
        if (isset($data['isbn'])) {
            $existingBook = $this->entityManager->getRepository(Book::class)->findOneBy(['isbn' => $data['isbn']]);
            if ($existingBook && $existingBook->getId() !== $book->getId()) {
                return $this->json(['message' => 'Another book with this ISBN already exists'], 409);
            }
            $book->setIsbn($data['isbn']);
        }
        if (isset($data['title'])) {
            $book->setTitle($data['title']);
        }
        if (isset($data['author'])) {
            $book->setAuthor($data['author']);
        }
        if (isset($data['publishedYear'])) {
            $book->setPublishedYear($data['publishedYear']);
        }
        if (isset($data['genre'])) {
            $book->setGenre($data['genre']);
        }

        $this->entityManager->flush();

        return $this->json($book);
    }

    // 5. Delete a book (by ID)
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['message' => 'Book not found'], 404);
        }

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return $this->json(['message' => 'Book deleted']);
    }
}
