<?php

class EventMedia {
    private $eventID;
    private $media;
    private $title;
    private $format;
    private $id;

    function __construct($eventID, $media, $title, $format, $id) {
        $this->eventID = $eventID;
        $this->media = $media;
        $this->title = $title;
        $this->format = $format;
        $this->id = $id;
    }

    function getMediaFormat() {
        return $format;
    }

    function getTitle() {
        return $title;
    }

    function getID() {
        return $id;
    }
}