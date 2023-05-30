<?php

namespace App\Entity;

use App\Entity\Genre;
use App\Entity\Music;
use App\Entity\Quote;
use App\Entity\Staff;
use App\Entity\Theme;
use App\Entity\Title;
use App\Entity\Figure;
use App\Entity\Studio;
use App\Entity\Episode;
use App\Entity\License;
use ApiPlatform\Metadata\Get;
use App\Entity\StreamingLink;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Images\CoverImage;
use App\Entity\Images\PosterImage;
use App\Repository\AnimeRepository;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnimeRepository::class)]
#[ApiResource(
    operations: [
        new Get(security: 'is_granted("ROLE_USER_API") or is_granted("ROLE_ADMIN")'),
        new GetCollection(security: 'is_granted("ROLE_USER_API") or is_granted("ROLE_ADMIN")'),
        new Post(security: 'is_granted("ROLE_USER_API") or is_granted("ROLE_ADMIN")'),
    ],
    normalizationContext: [
        'groups' => [Anime::ANIME_READ]
    ],
    denormalizationContext: [
        'groups' => [Anime::ANIME_WRITE]
    ],
)]
#[ORM\HasLifecycleCallbacks]
class Anime
{
    public const ANIME_READ = 'anime:read';
    public const ANIME_WRITE = 'anime:write';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Groups([Anime::ANIME_READ])]
    #[ORM\Column(length: 255)]
    #[ApiProperty(identifier: true)]
    private ?string $slug = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $synopsis = null;
    
    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $canonicalTitle = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?float $averageRating = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $userCount = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $upVoteCount = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?\DateTimeImmutable $startDate = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endDate = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $nextRelease = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $popularityRank = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $ratingRank = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $ageRating = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $ageRatingGuide = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $origin = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $episodeCount = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $episodeLength = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $totalLength = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $youtubeVideoId = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?bool $nsfw = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Title $title = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'animes', cascade: ['persist'])]
    private Collection $genre;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\OneToMany(mappedBy: 'anime', targetEntity: Episode::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $episode;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\OneToMany(mappedBy: 'anime', targetEntity: Figure::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $figure;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\ManyToMany(targetEntity: Staff::class, inversedBy: 'animes', cascade: ['persist'])]
    private Collection $staff;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\OneToMany(mappedBy: 'anime', targetEntity: music::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $music;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\OneToMany(mappedBy: 'anime', targetEntity: Quote::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $quote;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\ManyToMany(targetEntity: StreamingLink::class, inversedBy: 'animes', cascade: ['persist'])]
    private Collection $streamingLink;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\ManyToOne(inversedBy: 'animes', cascade: ['persist'])]
    private ?License $license = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\ManyToMany(targetEntity: Theme::class, inversedBy: 'animes', cascade: ['persist'])]
    private Collection $theme;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\ManyToOne(inversedBy: 'animes', cascade: ['persist'])]
    private ?Studio $studio = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column(length: 255)]
    private ?string $showType = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?float $score = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\Column]
    private ?int $favorite = null;

    #[Groups([Anime::ANIME_READ, Anime::ANIME_WRITE])]
    #[ORM\OneToMany(mappedBy: 'anime', targetEntity: Notice::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $avis;

    #[Groups([Anime::ANIME_READ])]
    #[ORM\OneToMany(mappedBy: 'anime', targetEntity: PosterImage::class)]
    private Collection $posterImage;

    #[Groups([Anime::ANIME_READ])]
    #[ORM\OneToMany(mappedBy: 'anime', targetEntity: CoverImage::class)]
    private Collection $coverImage;

    #[Groups([Anime::ANIME_READ])]
    #[ORM\ManyToMany(targetEntity: self::class)]
    #[ORM\JoinTable(name: 'anime_relationships')]
    private Collection $relationship;

    #[Groups([Anime::ANIME_READ])]
    #[ORM\Column]
    private ?int $nbrSeason = null;

    public function __construct()
    {
        $this->genre = new ArrayCollection();
        $this->episode = new ArrayCollection();
        $this->figure = new ArrayCollection();
        $this->staff = new ArrayCollection();
        $this->music = new ArrayCollection();
        $this->quote = new ArrayCollection();
        $this->streamingLink = new ArrayCollection();
        $this->theme = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->posterImage = new ArrayCollection();
        $this->coverImage = new ArrayCollection();
        $this->relationship = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

    public function setAverageRating(float $averageRating): self
    {
        $this->averageRating = $averageRating;

        return $this;
    }

    public function getUserCount(): ?int
    {
        return $this->userCount;
    }

    public function setUserCount(int $userCount): self
    {
        $this->userCount = $userCount;

        return $this;
    }

    public function getUpVoteCount(): ?int
    {
        return $this->upVoteCount;
    }

    public function setUpVoteCount(int $upVoteCount): self
    {
        $this->upVoteCount = $upVoteCount;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getNextRelease(): ?\DateTimeImmutable
    {
        return $this->nextRelease;
    }

    public function setNextRelease(?\DateTimeImmutable $nextRelease): self
    {
        $this->nextRelease = $nextRelease;

        return $this;
    }

    public function getPopularityRank(): ?int
    {
        return $this->popularityRank;
    }

    public function setPopularityRank(int $popularityRank): self
    {
        $this->popularityRank = $popularityRank;

        return $this;
    }

    public function getRatingRank(): ?int
    {
        return $this->ratingRank;
    }

    public function setRatingRank(int $ratingRank): self
    {
        $this->ratingRank = $ratingRank;

        return $this;
    }

    public function getAgeRating(): ?string
    {
        return $this->ageRating;
    }

    public function setAgeRating(string $ageRating): self
    {
        $this->ageRating = $ageRating;

        return $this;
    }

    public function getAgeRatingGuide(): ?string
    {
        return $this->ageRatingGuide;
    }

    public function setAgeRatingGuide(string $ageRatingGuide): self
    {
        $this->ageRatingGuide = $ageRatingGuide;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEpisodeCount(): ?int
    {
        return $this->episodeCount;
    }

    public function setEpisodeCount(int $episodeCount): self
    {
        $this->episodeCount = $episodeCount;

        return $this;
    }

    public function getEpisodeLength(): ?int
    {
        return $this->episodeLength;
    }

    public function setEpisodeLength(int $episodeLength): self
    {
        $this->episodeLength = $episodeLength;

        return $this;
    }

    /**
    * Calculate the length of all episodes
    */
    #[ORM\PrePersist]
    public function setCountTotalLength(): void
    {
        $this->totalLength = $this->episodeCount * $this->episodeLength;
    }

    public function getTotalLength(): ?int
    {
        return $this->totalLength;
    }

    public function setTotalLength(int $totalLength): self
    {
        $this->totalLength = $totalLength;

        return $this;
    }

    public function getYoutubeVideoId(): ?string
    {
        return $this->youtubeVideoId;
    }

    public function setYoutubeVideoId(string $youtubeVideoId): self
    {
        $this->youtubeVideoId = $youtubeVideoId;

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

    public function getTitle(): ?Title
    {
        return $this->title;
    }

    public function setTitle(Title $title): self
    {
        $this->title = $title;
        $slugger = new AsciiSlugger();
        $slugify = $slugger->slug(strtolower($this->title->getEn()));    
        $this->setSlug($slugify);
        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genre->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection<int, Episode>
     */
    public function getEpisode(): Collection
    {
        return $this->episode;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episode->contains($episode)) {
            $this->episode->add($episode);
            $episode->setAnime($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->episode->removeElement($episode)) {
            // set the owning side to null (unless already changed)
            if ($episode->getAnime() === $this) {
                $episode->setAnime(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Figure>
     */
    public function getFigure(): Collection
    {
        return $this->figure;
    }

    public function addFigure(Figure $figure): self
    {
        if (!$this->figure->contains($figure)) {
            $this->figure->add($figure);
            $figure->setAnime($this);
        }

        return $this;
    }

    public function removeFigure(Figure $figure): self
    {
        if ($this->figure->removeElement($figure)) {
            // set the owning side to null (unless already changed)
            if ($figure->getAnime() === $this) {
                $figure->setAnime(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Staff>
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(Staff $staff): self
    {
        if (!$this->staff->contains($staff)) {
            $this->staff->add($staff);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        $this->staff->removeElement($staff);

        return $this;
    }

    /**
     * @return Collection<int, music>
     */
    public function getMusic(): Collection
    {
        return $this->music;
    }

    public function addMusic(music $music): self
    {
        if (!$this->music->contains($music)) {
            $this->music->add($music);
            $music->setAnime($this);
        }

        return $this;
    }

    public function removeMusic(music $music): self
    {
        if ($this->music->removeElement($music)) {
            // set the owning side to null (unless already changed)
            if ($music->getAnime() === $this) {
                $music->setAnime(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quote>
     */
    public function getQuote(): Collection
    {
        return $this->quote;
    }

    public function addQuote(Quote $quote): self
    {
        if (!$this->quote->contains($quote)) {
            $this->quote->add($quote);
            $quote->setAnime($this);
        }

        return $this;
    }

    public function removeQuote(Quote $quote): self
    {
        if ($this->quote->removeElement($quote)) {
            // set the owning side to null (unless already changed)
            if ($quote->getAnime() === $this) {
                $quote->setAnime(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StreamingLink>
     */
    public function getStreamingLink(): Collection
    {
        return $this->streamingLink;
    }

    public function addStreamingLink(StreamingLink $streamingLink): self
    {
        if (!$this->streamingLink->contains($streamingLink)) {
            $this->streamingLink->add($streamingLink);
        }

        return $this;
    }

    public function removeStreamingLink(StreamingLink $streamingLink): self
    {
        $this->streamingLink->removeElement($streamingLink);

        return $this;
    }

    public function getLicense(): ?License
    {
        return $this->license;
    }

    public function setLicense(?License $license): self
    {
        $this->license = $license;

        return $this;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getTheme(): Collection
    {
        return $this->theme;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->theme->contains($theme)) {
            $this->theme->add($theme);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        $this->theme->removeElement($theme);

        return $this;
    }

    public function getStudio(): ?Studio
    {
        return $this->studio;
    }

    public function setStudio(?Studio $studio): self
    {
        $this->studio = $studio;

        return $this;
    }

    public function getShowType(): ?string
    {
        return $this->showType;
    }

    public function setShowType(string $showType): self
    {
        $this->showType = $showType;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getFavorite(): ?int
    {
        return $this->favorite;
    }

    public function setFavorite(int $favorite): self
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * @return Collection<int, notice>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(notice $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setAnime($this);
        }

        return $this;
    }

    public function removeAvi(notice $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getAnime() === $this) {
                $avi->setAnime(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PosterImage>
     */
    public function getPosterImage(): Collection
    {
        return $this->posterImage;
    }

    public function addPosterImage(PosterImage $posterImage): self
    {
        if (!$this->posterImage->contains($posterImage)) {
            $this->posterImage->add($posterImage);
            $posterImage->setAnime($this);
        }

        return $this;
    }

    public function removePosterImage(PosterImage $posterImage): self
    {
        if ($this->posterImage->removeElement($posterImage)) {
            // set the owning side to null (unless already changed)
            if ($posterImage->getAnime() === $this) {
                $posterImage->setAnime(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CoverImage>
     */
    public function getCoverImage(): Collection
    {
        return $this->coverImage;
    }

    public function addCoverImage(CoverImage $coverImage): self
    {
        if (!$this->coverImage->contains($coverImage)) {
            $this->coverImage->add($coverImage);
            $coverImage->setAnime($this);
        }

        return $this;
    }

    public function removeCoverImage(CoverImage $coverImage): self
    {
        if ($this->coverImage->removeElement($coverImage)) {
            // set the owning side to null (unless already changed)
            if ($coverImage->getAnime() === $this) {
                $coverImage->setAnime(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getRelationship(): Collection
    {
        return $this->relationship;
    }

    public function addRelationship(self $relationship): self
    {
        if (!$this->relationship->contains($relationship)) {
            $this->relationship->add($relationship);
        }

        return $this;
    }

    public function removeRelationship(self $relationship): self
    {
        $this->relationship->removeElement($relationship);

        return $this;
    }

    public function getNbrSeason(): ?int
    {
        return $this->nbrSeason;
    }

    public function setNbrSeason(int $nbrSeason): self
    {
        $this->nbrSeason = $nbrSeason;

        return $this;
    }


}
