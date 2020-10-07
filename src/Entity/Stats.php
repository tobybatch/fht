<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use DateTimeInterface;
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
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $lastUpdated;

    /**
     * @ORM\Column(type="float")
     */
    private float $scorePerMinute;

    /**
     * @ORM\Column(type="float")
     */
    private float $kdr;

    /**
     * @ORM\Column(type="float")
     */
    private float $killsPerMin;

    /**
     * @ORM\Column(type="float")
     */
    private float $accuracy;

    /**
     * @ORM\Column(type="integer")
     */
    private int $longestHeadshot;

    /**
     * @ORM\Column(type="integer")
     */
    private int $timePlayed;

    /**
     * @ORM\Column(type="integer")
     */
    private int $player_rank;

    /**
     * @ORM\Column(type="integer")
     */
    private int $killStreak;

    /**
     * @ORM\Column(type="string", length=48)
     */
    private string $topClass;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $topWeapon;

    /**
     * @ORM\Column(type="integer")
     */
    private int $topWeaponKills;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="Stats")
     * @ORM\JoinColumn(nullable=false)
     */
    private Player $player;

    /**
     * @ORM\Column(type="float")
     */
    private float $winLossPercent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastUpdated(): ?DateTimeInterface
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(DateTimeInterface $lastUpdated): self
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
        return $this->timePlayed;
    }

    public function setTimePlayed(int $timePlayed): self
    {
        $this->timePlayed = $timePlayed;

        return $this;
    }

    public function getPlayerRank(): ?int
    {
        return $this->player_rank;
    }

    public function setPlayerRank(int $player_rank): self
    {
        $this->player_rank = $player_rank;

        return $this;
    }

    public function getKillStreak(): ?int
    {
        return $this->killStreak;
    }

    public function setKillStreak(int $KillStreak): self
    {
        $this->killStreak = $KillStreak;

        return $this;
    }

    public function getTopClass(): ?string
    {
        return $this->topClass;
    }

    public function setTopClass(string $TopClass): self
    {
        $this->topClass = $TopClass;

        return $this;
    }

    public function getTopWeapon(): ?string
    {
        return $this->topWeapon;
    }

    public function setTopWeapon(string $TopWeapon): self
    {
        $this->topWeapon = $TopWeapon;

        return $this;
    }

    public function getTopWeaponKills(): ?int
    {
        return $this->topWeaponKills;
    }

    public function setTopWeaponKills(int $TopWeaponKills): self
    {
        $this->topWeaponKills = $TopWeaponKills;

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
