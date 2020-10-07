<?php

namespace App\DataFixtures;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlayerSeedFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $data = [
          [
            'network' => 'psn',
            'username' => 'ID_SPARTA',
            'player_name' => 'Toby',
          ],
          [
            'network' => 'psn',
            'username' => 'StarWarsDrummer',
            'player_name' => 'Al',
          ],
          [
            'network' => 'psn',
            'username' => 'Buffalo38',
            'player_name' => 'Tony',
          ],
          [
            'network' => 'psn',
            'username' => 'EschatonChampion',
            'player_name' => 'Ian',
          ],
          [
            'network' => 'psn',
            'username' => 'ABC-Warrior',
            'player_name' => 'John E.',
          ],
          [
            'network' => 'psn',
            'username' => 'mr_n_mrs_strong',
            'player_name' => 'John H.',
          ],
          [
            'network' => 'psn',
            'username' => 'Meister_Guenther',
            'player_name' => 'Grant',
          ],
        ];

        foreach ($data as $item) {
            $player = new Player();
            $player->setNetwork($item['network']);
            $player->setPlayerName($item['player_name']);
            $player->setUsername($item['username']);
            $manager->persist($player);
        }

        $manager->flush();
    }
}
