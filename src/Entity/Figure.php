<?php

namespace App\Entity;

use App\Entity\Anime;
use App\Entity\Staff;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Images\FigureImage;
use App\Repository\FigureRepository;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: FigureRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
    ],
)]
class Figure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\ManyToOne(inversedBy: 'figure')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Anime $anime = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    #[ApiProperty(identifier: true)]
    private ?string $slug = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\OneToOne(inversedBy: 'figure', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Name $name = null;

    #[Groups([Anime::ANIME_READ])]
    #[ORM\OneToMany(mappedBy: 'figure', targetEntity: FigureImage::class)]
    #[SerializedName('image')]
    private Collection $figureImage;

    #[ORM\ManyToOne(inversedBy: 'figure')]
    private ?Staff $staff = null;

    public function __construct()
    {
        $this->figureImage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getName(): ?Name
    {
        return $this->name;
    }

    public function setName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Figure>
     */
    public function getFigureImage(): Collection
    {
        return $this->figureImage;
    }

    public function addFigureImage(FigureImage $figureImage): self
    {
        if (!$this->figureImage->contains($figureImage)) {
            $this->figureImage->add($figureImage);
            $figureImage->setFigure($this);
        }

        return $this;
    }

    public function removeFigureImage(FigureImage $figureImage): self
    {
        if ($this->figureImage->removeElement($figureImage)) {
            // set the owning side to null (unless already changed)
            if ($figureImage->getFigure() === $this) {
                $figureImage->setFigure(null);
            }
        }

        return $this;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }
}
