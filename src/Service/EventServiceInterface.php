<?php

namespace App\Service;

use App\Model\Event;
use Symfony\Component\HttpFoundation\Request;

interface EventServiceInterface
{

    public function getEvents(): array;

    public function getEventById(int $id): Event;

    public function createEvent(Event $event): Event;

    public function updateEvent(int $id,Event $event): Event;

    public function deleteEvent(int $id): void;

    public function initialize():void;




}