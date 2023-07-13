<?php

namespace App\DataFixtures;

use App\Entity\PaymentType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaymentTypeFixtures extends Fixture
{
    public const PAYMENT_TYPE_1 = 'PAYMENT_TYPE_1';
    public const PAYMENT_TYPE_2 = 'PAYMENT_TYPE_2';
    public const PAYMENT_TYPE_3 = 'PAYMENT_TYPE_3';
    public const PAYMENT_TYPE_4 = 'PAYMENT_TYPE_4';

    public $paymentTypeListData = [
        'Оплата услуг',
        'Расчет биллинговой системы',
        'Перерасчет',
        'Бонус-начисление',
    ];

    public function load(ObjectManager $manager): void
    {
        $paymentTypeList = [];

        foreach ($this->paymentTypeListData as $paymentTypeName) {
            $paymentType = new PaymentType();
            $paymentType->setNAME($paymentTypeName);
            $manager->persist($paymentType);

            $paymentTypeList[] = $paymentType;
        }

        $manager->flush();

        $this->addReference(self::PAYMENT_TYPE_1, $paymentTypeList[0]);
        $this->addReference(self::PAYMENT_TYPE_2, $paymentTypeList[1]);
        $this->addReference(self::PAYMENT_TYPE_3, $paymentTypeList[2]);
        $this->addReference(self::PAYMENT_TYPE_4, $paymentTypeList[3]);
    }
}
