<?php

namespace App\Model;

class Event
{

public int $id;
public string $title;
public string $location;
public string $date;
public bool $isPublic;

    /**
     * @param int $id
     * @param string $title
     * @param string $location
     * @param string $date
     * @param bool $isPublic
     */
    public function __construct(int $id, string $title, string $location, string $date, bool $isPublic)
    {
        $this->id = $id;
        $this->title = $title;
        $this->location = $location;
        $this->date = $date;
        $this->isPublic = $isPublic;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }




}