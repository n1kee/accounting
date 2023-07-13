<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use App\Type\ClientTypes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @extends AbstractController
 *
 * @method Response index()
 * @method Response report($request)
 */
class ServiceController extends AbstractController
{
    public function __construct(
        protected ServiceRepository $serviceRepository,
    ) {
    }

    /**
     * Отображает главную страницу.
     */
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('report.html.twig');
    }

    /**
     * Возвращает ответ с данными отчета по услугам
     */
    #[Route('/report', name: 'app_service_report')]
    public function report(Request $request): Response
    {
        $params = $request->query->all();
        $clientTypeParam = $request->query->get('client_type');
        $clientType = is_numeric($clientTypeParam) ? ClientTypes::from($clientTypeParam) : null;

        if (isset($params['date'])) {
            $date = $params['date'];

            $date = array_map('intval', $date);

            $timestamp = mktime(0, 0, 0, ++$date['month'], 1, $date['year']);

            $datetime = \DateTime::createFromFormat('U', $timestamp);
        }

        $report = $this->serviceRepository->getReport($datetime ?? null, $clientType);

        return $this->json($report);
    }
}
