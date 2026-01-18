<?php

namespace App\Serializer;

class CircularReferenceHandler
{
    public function __invoke($object): string|int
    {
        // Si le serializer tourne en rond, on renvoie l'ID au lieu de l'objet
        return $object->getId();
    }
}
