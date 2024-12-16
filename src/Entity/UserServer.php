<?php

namespace App\Entity;

use App\Repository\UserServerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserServerRepository::class)]
class UserServer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'userServers')]
    private Collection $userId;

    /**
     * @var Collection<int, Server>
     */
    #[ORM\ManyToMany(targetEntity: Server::class, inversedBy: 'userServers')]
    private Collection $serverId;

    #[ORM\Column(length: 25)]
    private ?string $role = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $joinedAt = null;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
        $this->serverId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->userId->contains($userId)) {
            $this->userId->add($userId);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        $this->userId->removeElement($userId);

        return $this;
    }

    /**
     * @return Collection<int, Server>
     */
    public function getServerId(): Collection
    {
        return $this->serverId;
    }

    public function addServerId(Server $serverId): static
    {
        if (!$this->serverId->contains($serverId)) {
            $this->serverId->add($serverId);
        }

        return $this;
    }

    public function removeServerId(Server $serverId): static
    {
        $this->serverId->removeElement($serverId);

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getJoinedAt(): ?\DateTimeImmutable
    {
        return $this->joinedAt;
    }

    public function setJoinedAt(\DateTimeImmutable $joinedAt): static
    {
        $this->joinedAt = $joinedAt;

        return $this;
    }
}
