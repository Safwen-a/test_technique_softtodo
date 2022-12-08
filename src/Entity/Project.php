<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\Column(nullable: true)]
    private ?int $number_of_tasks = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last_updated = null;

    private $last_updated_day = null;

    public function setUpdated(): void
    {
        // will NOT be saved in the database
        $this->updated->modify("now");
    }

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getNumberOfTasks(): ?int
    {
        return $this->number_of_tasks;
    }

    public function setNumberOfTasks(?int $number_of_tasks): self
    {
        $this->number_of_tasks = $number_of_tasks;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLastUpdated(): ?string
    {
        return $this->last_updated;
    }

    public function setLastUpdated(string $last_updated): self
    {
        $this->last_updated = $last_updated;

        return $this;
    }
    public function getLastUpdatedDay(): ?string
    {
        return $this->last_updated;
    }

    public function setLastUpdatedDay(string $last_updated): self
    {
        $this->last_updated = $last_updated;

        return $this;
    }
}
