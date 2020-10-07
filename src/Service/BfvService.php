<?php

namespace App\Service;

use App\Entity\Player;
use App\Entity\Stats;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class BfvService
{
    public const FETCH_URL = "https://api.tracker.gg/api/v1/bfv/profile/%s/%s";
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetchStats(Player $player): Player {
        $url = sprintf(self::FETCH_URL, $player->getNetwork(), $player->getUsername());
        $json = file_get_contents($url);
        $data = json_decode($json, TRUE);
        $stats = $this->buildStats($data);
        $player->addStat($stats);

        $this->entityManager->persist($stats);
        $this->entityManager->persist($player);
        $this->entityManager->flush();

        return $player;
    }

    public function buildStats(array $data): Stats {
        $rawstats = $data['data']['stats'];


        $stats = new Stats();
        $stats->setLastUpdated(new \DateTime($data['lastUpdated']));
        $stats->setAccuracy($rawstats['shotsAccuracy']['value']);
        $stats->setKdr($rawstats['kdRatio']['value']);
        $stats->setKillsPerMin($rawstats['killsPerMinute']['value']);
        $stats->setKillStreak($rawstats['killStreak']['value']);
        $stats->setLongestHeadshot($rawstats['longestHeadshot']['value']);
        $stats->setPlayerRank($rawstats['rank']['value']);
        $stats->setScorePerMinute($rawstats['scorePerMinute']['value']);
        $stats->setTimePlayed($rawstats['timePlayed']['value']);
        $stats->setWinLossPercent($rawstats['wlPercentage']['value']);

        $topscore = 0;
        $topclass = "unknown";
        foreach ($data['data']['classes'] as $class) {
            $score = $class['score']['value'];
            if ($score > $topscore) {
                $topscore = $score;
                $topclass = $class['class'];
            }
        }
        $stats->setTopClass($topclass);

        $topWeaponKills = 0;
        $topWeapon = "unknown";
        foreach ($data['data']['weapons'] as $weapon) {
            $kills = $weapon['kills']['value'];
            if ($kills > $topWeaponKills) {
                $topWeaponKills = $kills;
                $topWeapon = $weapon['code'];
            }
        }
        $stats->setTopWeapon($topWeapon);
        $stats->setTopWeaponKills($topWeaponKills);

        return $stats;
    }

    public function getStatsFromPLayer(Player $player): array
    {
        $stats = $player->getStats()->toArray();
        usort($stats, function($one, $two) {
            return $one->getLastUpdated() < $two->getLastUpdated();
        });
        $uniq = [];
        foreach ($stats as $stat) {
            $uniq[$stat->getLastUpdated()->getTimestamp()] = $stat;
        }
        return array_values($uniq);
    }
}
