<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class JsonLdContextSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', -10],
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        // Vérifie si c'est une réponse API Platform en JSON-LD
        if (! str_starts_with($request->getPathInfo(), '/api/')) {
            return;
        }

        $contentType = $response->headers->get('Content-Type');
        if (! $contentType || ! str_contains($contentType, 'application/ld+json')) {
            return;
        }

        $content = json_decode($response->getContent(), true);

        if (! $content || ! isset($content['@context']) || ! is_array($content['@context'])) {
            return;
        }

        // Extrait le shortName de la ressource depuis @type
        if (isset($content['@type'])) {
            $resourceType = $content['@type'];

            // Remplace le contexte embarqué par une référence
            $content['@context'] = "/api/contexts/$resourceType";

            $response->setContent(json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        }

        // Gère aussi les collections (hydra:member)
        if (isset($content['hydra:member']) && is_array($content['hydra:member'])) {
            foreach ($content['hydra:member'] as &$item) {
                if (isset($item['@context']) && is_array($item['@context']) && isset($item['@type'])) {
                    $item['@context'] = "/api/contexts/{$item['@type']}";
                }
            }
            unset($item);

            $response->setContent(json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        }
    }
}
