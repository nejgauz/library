<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Assert\NotBlank(
     *     message="Заполните название"
     * )
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Максимальное количество символов в названии: 255"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @Assert\NotNull(
     *     message="Заполните год"
     * )
     * @Assert\Positive(
     *     message="Значение года должно быть положительным (в данной версии приложения нет возможности добавлять книги с годом написания до н.э.)"
     * )
     * @ORM\Column(type="smallint")
     */
    private int $year;

    /**
     * @Assert\NotBlank(
     *     message="Заполните имя автора"
     * )
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Максимальное количество символов в имени автора: 64"
     * )
     * @ORM\Column(type="string", length=64)
     */
    private string $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }
}
