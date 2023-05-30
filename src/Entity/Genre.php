<?php

namespace App\Entity;

use App\Entity\Anime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GenreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $totalMediaCount = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?bool $nsfw = null;

    #[ORM\ManyToMany(targetEntity: Anime::class, mappedBy: 'genre',)]
    private Collection $animes;

    public function __construct()
    {
        $this->animes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTotalMediaCount(): ?int
    {
        return $this->totalMediaCount;
    }

    public function setTotalMediaCount(int $totalMediaCount): self
    {
        $this->totalMediaCount = $totalMediaCount;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isNsfw(): ?bool
    {
        return $this->nsfw;
    }

    public function setNsfw(bool $nsfw): self
    {
        $this->nsfw = $nsfw;

        return $this;
    }

    /**
     * @return Collection<int, Anime>
     */
    public function getAnimes(): Collection
    {
        return $this->animes;
    }

    public function addAnime(Anime $anime): self
    {
        if (!$this->animes->contains($anime)) {
            $this->animes->add($anime);
            $anime->addGenre($this);
        }

        return $this;
    }

    public function removeAnime(Anime $anime): self
    {
        if ($this->animes->removeElement($anime)) {
            $anime->removeGenre($this);
        }

        return $this;
    }
}
