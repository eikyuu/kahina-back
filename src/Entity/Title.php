<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Episode;
use App\Repository\Anime\TitleRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TitleRepository::class)]
class Title
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $en = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enJp = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $jaJp = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fr = null;

    #[ORM\OneToOne(mappedBy: 'title', cascade: ['persist', 'remove'])]
    private ?Episode $episode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEn(): ?string
    {
        return $this->en;
    }

    public function setEn(?string $en): self
    {
        $this->en = $en;

        return $this;
    }

    public function getEnJp(): ?string
    {
        return $this->enJp;
    }

    public function setEnJp(?string $enJp): self
    {
        $this->enJp = $enJp;

        return $this;
    }

    public function getJaJp(): ?string
    {
        return $this->jaJp;
    }

    public function setJaJp(?string $jaJp): self
    {
        $this->jaJp = $jaJp;

        return $this;
    }

    public function getFr(): ?string
    {
        return $this->fr;
    }

    public function setFr(?string $fr): self
    {
        $this->fr = $fr;

        return $this;
    }

    public function getEpisode(): ?Episode
    {
        return $this->episode;
    }

    public function setEpisode(?Episode $episode): self
    {
        // unset the owning side of the relation if necessary
        if ($episode === null && $this->episode !== null) {
            $this->episode->setTitle(null);
        }

        // set the owning side of the relation if necessary
        if ($episode !== null && $episode->getTitle() !== $this) {
            $episode->setTitle($this);
        }

        $this->episode = $episode;

        return $this;
    }
}
