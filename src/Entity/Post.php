<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Header;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $HeaderText;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PhotoLink;

    /**
     * @ORM\Column(type="text")
     */
    private $Text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Tag;

    /**
     * @ORM\Column(type="string")
     */
    private $Date;

    /**
     * @ORM\Column(type="integer")
     */
    private $hearts;

    /**
     * @ORM\Column(type="integer")
     */
    private $Views;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeader(): ?string
    {
        return $this->Header;
    }

    public function setHeader(string $Header): self
    {
        $this->Header = $Header;

        return $this;
    }

    public function getHeaderText(): ?string
    {
        return $this->HeaderText;
    }

    public function setHeaderText(string $HeaderText): self
    {
        $this->HeaderText = $HeaderText;

        return $this;
    }

    public function getPhotoLink(): ?string
    {
        return $this->PhotoLink;
    }

    public function setPhotoLink(string $PhotoLink): self
    {
        $this->PhotoLink = $PhotoLink;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): self
    {
        $this->Text = $Text;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->Tag;
    }

    public function setTag(string $Tag): self
    {
        $this->Tag = $Tag;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param mixed $Date
     */
    public function setDate($Date): void
    {
        $this->Date = $Date;
    }

    public function getHearts(): ?int
    {
        return $this->hearts;
    }

    public function setHearts(int $hearts): self
    {
        $this->hearts = $hearts;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->Views;
    }

    public function setViews(int $Views): self
    {
        $this->Views = $Views;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->Slug;
    }

    public function setSlug(string $Slug): self
    {
        $this->Slug = $Slug;

        return $this;
    }
}


