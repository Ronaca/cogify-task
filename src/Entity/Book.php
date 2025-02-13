<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource] // Exposes it as a REST API resource
class Book
{
    #[ORM\Id, ORM\Column(length: 13), ORM\GeneratedValue]
    private ?string $isbn = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $title;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $author;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(min: 1000, max: 2100)]
    private int $publishedYear;

    #[ORM\Column(length: 50)]
    private string $genre;

    // Getters and Setters...
}

