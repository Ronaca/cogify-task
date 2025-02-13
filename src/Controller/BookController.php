<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/books')]
class BookController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $books = $em->getRepository(Book::class)->findAll();
        return $this->json($books);
    }

    #[Route('/{isbn}', methods: ['GET'])]
    public function getBook(string $isbn, EntityManagerInterface $em): JsonResponse
    {
        $book = $em->getRepository(Book::class)->find($isbn);
        return $book ? $this->json($book) : $this->json(['error' => 'Book not found'], 404);
    }

    #[Route('', methods: ['POST'])]
    public function addBook(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $book = new Book();
        $book->setTitle($data['title']);
        $book->setAuthor($data['author']);
        $book->setPublishedYear($data['publishedYear']);
        $book->setGenre($data['genre']);

        $em->persist($book);
        $em->flush();

        return $this->json($book, 201);
    }

    #[Route('/{isbn}', methods: ['PUT'])]
    public function updateBook(string $isbn, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $book = $em->getRepository(Book::class)->find($isbn);
        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $book->setTitle($data['title'] ?? $book->getTitle());
        $book->setAuthor($data['author'] ?? $book->getAuthor());
        $book->setPublishedYear($data['publishedYear'] ?? $book->getPublishedYear());
        $book->setGenre($data['genre'] ?? $book->getGenre());

        $em->flush();

        return $this->json($book);
    }

    #[Route('/{isbn}', methods: ['DELETE'])]
    public function deleteBook(string $isbn, EntityManagerInterface $em): JsonResponse
    {
        $book = $em->getRepository(Book::class)->find($isbn);
        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        $em->remove($book);
        $em->flush();

        return $this->json(['message' => 'Book deleted']);
    }
}

