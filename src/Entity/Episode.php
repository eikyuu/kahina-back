<?php

namespace App\Entity;

use App\Entity\Anime;
use App\Entity\Title;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use App\Entity\Images\Thumbnail;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\EpisodeRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EpisodeRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
    ],
)]
class Episode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $canonicalTitle = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $seasonNumber = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $number = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $synopsis = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $airdate = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $length = null;

    #[ORM\ManyToOne(inversedBy: 'episode')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Anime $anime = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\OneToOne(inversedBy: 'episode', cascade: ['persist', 'remove'])]
    private ?Title $title = null;

    #[Groups([Anime::ANIME_READ])]
    #[ORM\OneToMany(mappedBy: 'episode', targetEntity: Thumbnail::class)]
    private Collection $thumbnail;

    public function __construct()
    {
        $this->thumbnail = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCanonicalTitle(): ?string
    {
        return $this->canonicalTitle;
    }

    public function setCanonicalTitle(string $canonicalTitle): self
    {
        $this->canonicalTitle = $canonicalTitle;

        return $this;
    }

    public function getSeasonNumber(): ?int
    {
        return $this->seasonNumber;
    }

    public function setSeasonNumber(int $seasonNumber): self
    {
        $this->seasonNumber = $seasonNumber;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getAirdate(): ?\DateTimeImmutable
    {
        return $this->airdate;
    }

    public function setAirdate(\DateTimeImmutable $airdate): self
    {
        $this->airdate = $airdate;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getAnime(): ?Anime
    {
        return $this->anime;
    }

    public function setAnime(?Anime $anime): self
    {
        $this->anime = $anime;

        return $this;
    }

    public function getTitle(): ?Title
    {
        return $this->title;
    }

    public function setTitle(?Title $title): self
    {
        $this->title = $title;

        return $this;
    }

            /**
     * @return Collection<int, Thumbnail>
     */
    public function getThumbnail(): Collection
    {
        return $this->thumbnail;
    }

    public function addThumbnail(Thumbnail $thumbnail): self
    {
        if (!$this->thumbnail->contains($thumbnail)) {
            $this->thumbnail->add($thumbnail);
            $thumbnail->setEpisode($this);
        }

        return $this;
    }

    public function removeThumbnail(Thumbnail $thumbnail): self
    {
        if ($this->thumbnail->removeElement($thumbnail)) {
            // set the owning side to null (unless already changed)
            if ($thumbnail->getEpisode() === $this) {
                $thumbnail->setEpisode(null);
            }
        }

        return $this;
    }
}
