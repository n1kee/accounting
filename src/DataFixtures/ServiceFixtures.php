<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public const SERVICE_1 = 'SERVICE_1';
    public const SERVICE_2 = 'SERVICE_2';

    public $serviceListData = [
        'Интернет',
        'Хостинг',
    ];

    public function load(ObjectManager $manager): void
    {
        $serviceList = [];

        foreach ($this->serviceListData as $serviceName) {
            $service = new Service();
            $service->setNAME($serviceName);
            $manager->persist($service);

            $serviceList[] = $service;
        }

        $manager->flush();

        $this->addReference(self::SERVICE_1, $serviceList[0]);
        $this->addReference(self::SERVICE_2, $serviceList[1]);
    }
}
