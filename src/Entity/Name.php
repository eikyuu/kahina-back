<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NameRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NameRepository::class)]
class Name
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $romaji = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $english = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $native = null;

    #[ORM\OneToOne(mappedBy: 'name', cascade: ['persist', 'remove'])]
    private ?Figure $figure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRomaji(): ?string
    {
        return $this->romaji;
    }

    public function setRomaji(string $romaji): self
    {
        $this->romaji = $romaji;

        return $this;
    }

    public function getEnglish(): ?string
    {
        return $this->english;
    }

    public function setEnglish(string $english): self
    {
        $this->english = $english;

        return $this;
    }

    public function getNative(): ?string
    {
        return $this->native;
    }

    public function setNative(string $native): self
    {
        $this->native = $native;

        return $this;
    }

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    public function setFigure(Figure $figure): self
    {
        // set the owning side of the relation if necessary
        if ($figure->getName() !== $this) {
            $figure->setName($this);
        }

        $this->figure = $figure;

        return $this;
    }
}
