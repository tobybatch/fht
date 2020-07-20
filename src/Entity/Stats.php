<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsRepository::class)
 */
class Stats
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdated;

    /**
     * @ORM\Column(type="float")
     */
    private $scorePerMinute;

    /**
     * @ORM\Column(type="float")
     */
    private $kdr;

    /**
     * @ORM\Column(type="float")
     */
    private $killsPerMin;

    /**
     * @ORM\Column(type="float")
     */
    private $winPercentage;

    /**
     * @ORM\Column(type="float")
     */
    private $accuracy;

    /**
     * @ORM\Column(type="integer")
     */
    private $longestHeadshot;

    /**
     * @ORM\Column(type="integer")
     */
    private $timePlayed;

    /**
     * @ORM\Column(type="integer")
     */
    private $rank;

    /**
     * @ORM\Column(type="integer")
     */
    private $killStreak;

    /**
     * @ORM\Column(type="string", length=48)
     */
    private $topClass;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $topWeapon;

    /**
     * @ORM\Column(type="integer")
     */
    private $topWeaponKills;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="Stats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(type="float")
     */
    private $winLossPercent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastUpdated(): ?\DateTimeInterface
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(\DateTimeInterface $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    public function getScorePerMinute(): ?float
    {
        return $this->scorePerMinute;
    }

    public function setScorePerMinute(float $scorePerMinute): self
    {
        $this->scorePerMinute = $scorePerMinute;

        return $this;
    }

    public function getKdr(): ?float
    {
        return $this->kdr;
    }

    public function setKdr(float $kdr): self
    {
        $this->kdr = $kdr;

        return $this;
    }

    public function getKillsPerMin(): ?float
    {
        return $this->killsPerMin;
    }

    public function setKillsPerMin(float $killsPerMin): self
    {
        $this->killsPerMin = $killsPerMin;

        return $this;
    }

    public function getWinPercentage(): ?float
    {
        return $this->winPercentage;
    }

    public function setWinPercentage(float $winPercentage): self
    {
        $this->winPercentage = $winPercentage;

        return $this;
    }

    public function getAccuracy(): ?float
    {
        return $this->accuracy;
    }

    public function setAccuracy(float $accuracy): self
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function getLongestHeadshot(): ?int
    {
        return $this->longestHeadshot;
    }

    public function setLongestHeadshot(int $longestHeadshot): self
    {
        $this->longestHeadshot = $longestHeadshot;

        return $this;
    }

    public function getTimePlayed(): ?int
    {
        return $this->TimePlayed;
    }

    public function setTimePlayed(int $TimePlayed): self
    {
        $this->TimePlayed = $TimePlayed;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->Rank;
    }

    public function setRank(int $Rank): self
    {
        $this->Rank = $Rank;

        return $this;
    }

    public function getKillStreak(): ?int
    {
        return $this->KillStreak;
    }

    public function setKillStreak(int $KillStreak): self
    {
        $this->KillStreak = $KillStreak;

        return $this;
    }

    public function getTopClass(): ?string
    {
        return $this->TopClass;
    }

    public function setTopClass(string $TopClass): self
    {
        $this->TopClass = $TopClass;

        return $this;
    }

    public function getTopWeapon(): ?string
    {
        return $this->TopWeapon;
    }

    public function setTopWeapon(string $TopWeapon): self
    {
        $this->TopWeapon = $TopWeapon;

        return $this;
    }

    public function getTopWeaponKills(): ?int
    {
        return $this->TopWeaponKills;
    }

    public function setTopWeaponKills(int $TopWeaponKills): self
    {
        $this->TopWeaponKills = $TopWeaponKills;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getWinLossPercent(): ?float
    {
        return $this->winLossPercent;
    }

    public function setWinLossPercent(float $winLossPercent): self
    {
        $this->winLossPercent = $winLossPercent;

        return $this;
    }
}
