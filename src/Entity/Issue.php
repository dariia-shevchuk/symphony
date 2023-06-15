<?php

namespace App\Entity;

use App\Repository\IssueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IssueRepository::class)]
class Issue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'issues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?IssueCategory $category = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $contact_email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contact_phone = null;

    #[ORM\Column]
    private ?bool $is_contact_allowed = null;

    #[ORM\OneToMany(mappedBy: 'issue', targetEntity: IssueComment::class)]
    private Collection $issueComments;

    #[ORM\ManyToOne(inversedBy: 'issues')]
    private ?User $user = null;

    public function __construct()
    {
        $this->issueComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?IssueCategory
    {
        return $this->category;
    }

    public function setCategory(?IssueCategory $category): self
    {
        $this->category = $category;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contact_email;
    }

    public function setContactEmail(string $contact_email): self
    {
        $this->contact_email = $contact_email;

        return $this;
    }

    public function getContactPhone(): ?string
    {
        return $this->contact_phone;
    }

    public function setContactPhone(?string $contact_phone): self
    {
        $this->contact_phone = $contact_phone;

        return $this;
    }

    public function isIsContactAllowed(): ?bool
    {
        return $this->is_contact_allowed;
    }

    public function setIsContactAllowed(bool $is_contact_allowed): self
    {
        $this->is_contact_allowed = $is_contact_allowed;

        return $this;
    }

    /**
     * @return Collection<int, IssueComment>
     */
    public function getIssueComments(): Collection
    {
        return $this->issueComments;
    }

    public function addIssueComment(IssueComment $issueComment): self
    {
        if (!$this->issueComments->contains($issueComment)) {
            $this->issueComments->add($issueComment);
            $issueComment->setIssue($this);
        }

        return $this;
    }

    public function removeIssueComment(IssueComment $issueComment): self
    {
        if ($this->issueComments->removeElement($issueComment)) {
            // set the owning side to null (unless already changed)
            if ($issueComment->getIssue() === $this) {
                $issueComment->setIssue(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
