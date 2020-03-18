<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Place;
use App\Service\ListFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListController extends Controller
{
    /**
     * @Route("/list", name="list")
     * @param Request $request
     * @param ListFactory $listFactory
     */
    public function index(Request $request, ListFactory $listFactory)
    {
        $type = $request->query->get('type', 'html');
        $cityRepository = $this->getDoctrine()->getRepository(City::class);
        $placeRepository = $this->getDoctrine()->getRepository(Place::class);
        $response = new StreamedResponse();
        $response->headers->set('X-Accel-Buffering', 'no');
        $listFormatter = $listFactory->getListFormatter($type);
        $listFormatter->addHeaders($response);
        $response->setCallback(function () use ($cityRepository, $placeRepository, $listFormatter) {
            echo $listFormatter->addHead();
            echo $listFormatter->addTitleRow([
                'city',
                'id',
                'name',
                'slug',
                'active',
                'closed',
                'createdAt',
            ]);
            flush();
            $cities = $cityRepository->findAllIndexById();
            foreach ($placeRepository->iterate() as $items) {
                /** @var Place $item */
                foreach ($items as $item) {
//                    $item->setCity($cities[$item->getCityId()]);
                    $row = [
                        'city' => $cities[$item->getCityId()]->getName(),
                        'id' => $item->getId(),
                        'name' => $item->getName(),
                        'slug' => $item->getSlug(),
                        'active' => $item->getActive(),
                        'closed' => $item->getClosed(),
                        'createdAt' => $item->getCreatedAt()->format('Y.m.d H:i:s'),
                    ];
                    echo $listFormatter->addRow($row);
                    flush();
                }
            }
            echo $listFormatter->addTail();
            flush();
        });
        $response->send();
    }
}
