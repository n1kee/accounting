<?php

namespace App\Repository;

use App\Entity\Service;
use App\Type\ClientTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method array getReport($month, $clientType)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    /**
     * Генерирует отчет по услугам
     *
     * @param \DateTime|null   $month      За какой месяц
     * @param ClientTypes|null $clientType Тип клиента
     *
     * @return array Данные отчета по услугам
     */
    public function getReport(?\DateTime $month, ?ClientTypes $clientType): array
    {
        $qb = $this->createQueryBuilder('s');

        $clientTypeValue = $clientType ? $clientType->value : 'null';

        $noMonthFilter = empty($month) ? 'true' : 'false';
        $noTypeFilter = empty($clientType) ? 'true' : 'false';

        if ($month) {
            $nextMonth = clone $month;
            $nextMonth->modify('next month');
        } else {
            $month = new \DateTime();
            $nextMonth = new \DateTime();
        }

        $monthString = $month->format('Y-m-d');
        $nextMonthString = $nextMonth->format('Y-m-d');

        $sql = " 
            SELECT s.id,
                s.name,
                COALESCE(previously.sum, 0) as balance,
                COALESCE(month_income.sum, 0) as income,
                COALESCE(month_outcome.sum, 0) as outcome,
                COALESCE(month_recalculation.sum, 0) as recalculation,
                COALESCE(previously.sum, 0) + COALESCE(month_income.sum, 0) + COALESCE(month_outcome.sum, 0) as total

            FROM service s

            LEFT JOIN (
                SELECT acnt_id, SUM(summa) as sum
                FROM payment p
                INNER JOIN client c
                ON p.client_id = c.id
                WHERE ({$noMonthFilter}=true OR p.data < '{$monthString}')
                AND ({$noTypeFilter}=true OR c.type={$clientTypeValue})
                GROUP BY acnt_id
            ) as previously
            ON s.id = previously.acnt_id

            LEFT JOIN (
                SELECT p.acnt_id, SUM(p.summa) as sum
                FROM payment p
                INNER JOIN client c
                ON p.client_id = c.id
                WHERE (
                    {$noMonthFilter}=true
                    OR (p.data >= '{$monthString}' AND p.data < '{$nextMonthString}')
                )
                AND ({$noTypeFilter}=true OR c.type={$clientTypeValue})
                AND p.summa > 0
                GROUP BY p.acnt_id
            ) as month_income
            ON s.id = month_income.acnt_id

            LEFT JOIN (
                SELECT p.acnt_id, SUM(p.summa) as sum
                FROM payment p
                INNER JOIN client c
                ON p.client_id = c.id
                WHERE (
                    {$noMonthFilter}=true OR
                    (p.data >= '{$monthString}' AND p.data < '{$nextMonthString}')
                )
                AND ({$noTypeFilter}=true OR c.type={$clientTypeValue})
                AND p.summa < 0
                GROUP BY p.acnt_id
            ) as month_outcome
            ON s.id = month_outcome.acnt_id

            LEFT JOIN (
                SELECT p.acnt_id, SUM(p.summa) as sum
                FROM payment p
                INNER JOIN payment_type pt
                ON p.pay_id = pt.id
                INNER JOIN client c
                ON p.client_id = c.id
                WHERE (
                    {$noMonthFilter}=true OR
                    (p.data >= '{$monthString}' AND p.data < '{$nextMonthString}')
                )
                AND pt.name LIKE '%Перерасчет%'
                AND ({$noTypeFilter}=true OR c.type={$clientTypeValue})
                GROUP BY p.acnt_id
            ) as month_recalculation
            ON s.id = month_recalculation.acnt_id
        ";

        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->prepare($sql);

        return $stmt->execute()->fetchAll();
    }
}
