<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $paymentListData = [
            [
                'CLIENTID' => $this->getReference(ClientFixtures::CLIENT_1)->getId(),
                'SUMMA' => 535,
                'DATA' => new \DateTime('2023-06-02 20:17'),
                'DESCRIPTION' => 'Хороший платеж # 1',
                'ACNTID' => $this->getReference(ServiceFixtures::SERVICE_1)->getId(),
                'PAYID' => $this->getReference(PaymentTypeFixtures::PAYMENT_TYPE_1)->getId(),
            ],
            [
                'CLIENTID' => $this->getReference(ClientFixtures::CLIENT_1)->getId(),
                'SUMMA' => -120,
                'DATA' => new \DateTime('2023-06-04 20:17'),
                'DESCRIPTION' => 'Хороший платеж # 2',
                'ACNTID' => $this->getReference(ServiceFixtures::SERVICE_1)->getId(),
                'PAYID' => $this->getReference(PaymentTypeFixtures::PAYMENT_TYPE_2)->getId(),
            ],
            [
                'CLIENTID' => $this->getReference(ClientFixtures::CLIENT_1)->getId(),
                'SUMMA' => 239,
                'DATA' => new \DateTime('2023-06-03 20:17'),
                'DESCRIPTION' => 'Хороший платеж # 3',
                'ACNTID' => $this->getReference(ServiceFixtures::SERVICE_2)->getId(),
                'PAYID' => $this->getReference(PaymentTypeFixtures::PAYMENT_TYPE_1)->getId(),
            ],
            [
                'CLIENTID' => $this->getReference(ClientFixtures::CLIENT_2)->getId(),
                'SUMMA' => 468,
                'DATA' => new \DateTime('2023-06-10 20:17'),
                'DESCRIPTION' => 'Хороший платеж # 4',
                'ACNTID' => $this->getReference(ServiceFixtures::SERVICE_2)->getId(),
                'PAYID' => $this->getReference(PaymentTypeFixtures::PAYMENT_TYPE_1)->getId(),
            ],
            [
                'CLIENTID' => $this->getReference(ClientFixtures::CLIENT_2)->getId(),
                'SUMMA' => -100,
                'DATA' => new \DateTime('2023-06-12 20:17'),
                'DESCRIPTION' => 'Хороший платеж # 5',
                'ACNTID' => $this->getReference(ServiceFixtures::SERVICE_2)->getId(),
                'PAYID' => $this->getReference(PaymentTypeFixtures::PAYMENT_TYPE_2)->getId(),
            ],
            [
                'CLIENTID' => $this->getReference(ClientFixtures::CLIENT_1)->getId(),
                'SUMMA' => 50,
                'DATA' => new \DateTime('2023-04-02 20:17'),
                'DESCRIPTION' => 'Хороший платеж # 6',
                'ACNTID' => $this->getReference(ServiceFixtures::SERVICE_1)->getId(),
                'PAYID' => $this->getReference(PaymentTypeFixtures::PAYMENT_TYPE_1)->getId(),
            ],
        ];

        foreach ($paymentListData as $paymentData) {
            $payment = new Payment();

            $payment->setCLIENTID($paymentData['CLIENTID']);
            $payment->setSUMMA($paymentData['SUMMA']);
            $payment->setDATA($paymentData['DATA']);
            $payment->setDESCRIPTION($paymentData['DESCRIPTION']);
            $payment->setACNTID($paymentData['ACNTID']);
            $payment->setPAYID($paymentData['PAYID']);

            $manager->persist($payment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ClientFixtures::class,
            ServiceFixtures::class,
            PaymentTypeFixtures::class,
        ];
    }
}
