<?php

namespace App\Entity;

use App\Repository\ServerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServerRepository::class)]
class Server
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $serverName = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $iconUrl = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, UserServer>
     */
    #[ORM\ManyToMany(targetEntity: UserServer::class, mappedBy: 'serverId')]
    private Collection $userServers;

    public function __construct()
    {
        $this->userServers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServerName(): ?string
    {
        return $this->serverName;
    }

    public function setServerName(string $serverName): static
    {
        $this->serverName = $serverName;

        return $this;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function setIconUrl(?string $iconUrl): static
    {
        $this->iconUrl = $iconUrl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, UserServer>
     */
    public function getUserServers(): Collection
    {
        return $this->userServers;
    }

    public function addUserServer(UserServer $userServer): static
    {
        if (!$this->userServers->contains($userServer)) {
            $this->userServers->add($userServer);
            $userServer->addServerId($this);
        }

        return $this;
    }

    public function removeUserServer(UserServer $userServer): static
    {
        if ($this->userServers->removeElement($userServer)) {
            $userServer->removeServerId($this);
        }

        return $this;
    }
}
