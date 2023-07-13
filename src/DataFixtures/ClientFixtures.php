<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public const CLIENT_1 = 'CLIENT_1';
    public const CLIENT_2 = 'CLIENT_2';

    public function load(ObjectManager $manager): void
    {
        $clientListData = [
            [
                'Андрей Иванов',
                Client::TYPES::INDIVIDUAL->value,
            ],
            [
                'Борис Смирнов',
                Client::TYPES::LEGAL_ENTITY->value,
            ],
        ];

        $clientList = [];

        foreach ($clientListData as $clientData) {
            $client = new Client();
            $client->setNAME($clientData[0]);
            $client->setTYPE($clientData[1]);
            $manager->persist($client);

            $clientList[] = $client;
        }

        $manager->flush();

        $this->addReference(self::CLIENT_1, $clientList[0]);
        $this->addReference(self::CLIENT_2, $clientList[1]);
    }
}
