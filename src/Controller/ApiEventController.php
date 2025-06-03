<?php

namespace App\Controller;

use App\Model\Event;
use App\Service\EventServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/event')]
class ApiEventController extends AbstractController
{

    public function __construct(private EventServiceInterface $eventService){}


     #[Route('', name: 'get_events', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $location = $request->query->get('location');
        $events = $this->eventService->getEvents();

        if ($location) {
            $events = array_filter($events, fn($event) => $event->getLocation() === $location);
        }

        $array = array_map(fn($event) => get_object_vars($event), $events);
        return new JsonResponse($array, Response::HTTP_OK);
    }

     #[Route('/public', name: 'get_public_events', methods: ['GET'])]
     public function listPublic(Request $request): JsonResponse
     {
         $events = array_filter(
             $this->getEventsFromSession($request),
             fn($e) => $e->isPublic === true
         );

         $array = array_map(fn($e) => get_object_vars($e), $events);

         return new JsonResponse($array, Response::HTTP_OK);
     }

     #[Route('/{id}', name: 'get_event', methods: ['GET'])]
    public function get(int $id, Request $request): JsonResponse
    {
        try {
            $event = $this->eventService->getEventById($id);
            return new JsonResponse($event, Response::HTTP_OK);

        }catch (NotFoundHttpException $e){
            return new JsonResponse(['error' => $e->getMessage() ], Response::HTTP_NOT_FOUND);
        }

    }

     #[Route('', name: 'create_event', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


        $event = new Event(null,
            $data['title'],
            $data['location'],
            $data['date'],
            (bool)$data['isPublic']
        );

        $event = $this-> eventService->createEvent($event);

        return new JsonResponse([
            'message' => 'Événement créé',
            'event' => get_object_vars($event)
        ], Response::HTTP_CREATED);
    }

     #[Route('/{id}', name: 'update_event', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $event = new Event(
            $id,
            $data['title'],
            $data['location'],
            $data['date'],
            (bool)$data['isPublic']
        );

        $event = $this-> eventService->updateEvent($id,$event);

        return new JsonResponse([
            'message' => "Événement $id mis à jour",
            'event' => get_object_vars($event)
        ], Response::HTTP_OK);
    }

      #[Route('/{id}', name: 'delete_event', methods: ['DELETE'])]
    public function delete(int $id, Request $request): JsonResponse
    {
        try{
            $this->eventService->deleteEvent($id);
            return new JsonResponse([
                'message' => "Événement $id supprimé"
            ], Response::HTTP_NO_CONTENT);
        }catch (NotFoundHttpException $e){
            return new JsonResponse(['error' => $e -> getMessage(), Response::HTTP_NOT_FOUND]);
        }


    }
}
