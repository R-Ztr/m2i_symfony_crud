<?php

namespace App\Service\Impl;

use App\Model\Event;
use App\Service\EventServiceInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventService implements EventServiceInterface
{
    private string $sessionKey ="events";
    public function __construct(private SessionInterface $session){
        $this->initialize();
    }

    public function initialize(): void
    {
        if(!$this->session->has($this->sessionKey)){
            $this->session->set($this->sessionKey,[
                    1 => new Event(1, "DevSecOps Lille", "Lille", "2025-01-23", true),
                    2 => new Event(2, "Gouter anniversaire Vanessa", "Lyon", "2025-09-18", false)
                ]
            );
        }

    }

    public function getEvents(): array
    {
        return $this->session->get($this->sessionKey,[]);
    }

    public function getEventById(int $id): Event
    {
        $events = $this->getEvents();
        if(!isset($events[$id])){
            throw new NotFoundHttpException("Event avec $id introuvable.");
        }

        return $events[$id];

    }

    public function createEvent(Event $event): Event
    {
        $events = $this->getEvents();
        $id = rand(100, 999);
        $event->setId($id);
        $events[$id] = $event;
        $this->session->set($this->sessionKey,$events);

        return $events[$id];


    }

    public function updateEvent(int $id, Event $event): Event
    {
        $events = $this->getEvents();
        if(!isset($events[$id])){
            throw new NotFoundHttpException("Event avec $id itrouvable");
        }
        $events[$id] = $event;
        $this->session->set($this->sessionKey,$events);
        return $events[$id];
    }

    public function deleteEvent(int $id): void
    {
        $events = $this->getEvents();
        if(!isset($events[$id])){
            throw new Exception("Event avec $id itrouvable");
        }

        unset($events[$id]);
        $this->session->set($this->sessionKey,$events);

    }


}