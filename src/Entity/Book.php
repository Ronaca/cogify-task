<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;

#[ApiResource]
#[ORM\Entity]
#[ORM\Table(name: "books")]
class Book
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 20, unique: true)]
    #[ApiProperty(identifier: true)]
    #[Assert\NotBlank]  // Ensures isbn is not empty
    #[Assert\Length(min: 10, max: 20)]  // ISBN should be between 10-20 characters
    private ?string $isbn = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]  // Title must be between 2-255 characters
    private string $title;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]  // Author must be between 2-255 characters
    private string $author;

    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank]
    #[Assert\LessThanOrEqual(2100)]  // Ensures the year is not in the far future
    private int $publishedYear;

    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 100)]  // Genre must be between 2-100 characters
    private string $genre;

    // Getters and Setters

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getPublishedYear(): int
    {
        return $this->publishedYear;
    }

    public function setPublishedYear(int $publishedYear): self
    {
        $this->publishedYear = $publishedYear;
        return $this;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;
        return $this;
    }
}
