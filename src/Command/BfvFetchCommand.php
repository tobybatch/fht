<?php

namespace App\Command;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Service\BfvService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BfvFetchCommand extends Command
{
    protected static $defaultName = 'bfv:fetch';

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var PlayerRepository
     */
    private PlayerRepository $playerRepo;
    /**
     * @var BfvService
     */
    private BfvService $bfvService;

    public function __construct(
        EntityManagerInterface $entityManager,
        PlayerRepository $playerRepo,
        BfvService $bfvService
    )
    {
        $this->entityManager = $entityManager;
        $this->playerRepo = $playerRepo;
        $this->bfvService = $bfvService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetch updates for player(s).  If player name is provided that pleyer is fetched, else all players are fetched')
            ->addArgument('player', InputArgument::OPTIONAL, 'Player name to fetch')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $playerName = $input->getArgument('player');

        $players = [];
        if ($playerName) {
            $player = $this->playerRepo->findOneByUsername($playerName);
            if (!$player) {
                $io->error(sprintf("No such player, %s", $playerName));
                return Command::FAILURE;
            }
            $players[] = $player;
        } else {
            $allPlayers = $this->playerRepo->findAll();
            foreach ($allPlayers as $player) {
                $players[] = $player;
            }
        }

        foreach ($players as $player) {
            $io->comment(sprintf("Fetching stats for %s", $player->getUsername()));
            $this->bfvService->fetchStats($player);
        }

        $io->success('Done.');

        return Command::SUCCESS;
    }
}
