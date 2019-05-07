<?php

namespace Omikron\Factfinder\Prestashop\EventListener;

use Omikron\Factfinder\Prestashop\DataTransferObject\TestConnectionParams;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Serializer\Serializer;

class TestConnectionArgumentConverter
{
    /** @var Serializer */
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request    = $event->getRequest();
        $controller = $request->attributes->get('_controller');
        $controller = explode('::', $controller);
        try {
            new \ReflectionParameter($controller, 'testParams');
        } catch (\ReflectionException $e) {
            return;
        }

        if ($request->attributes->has('testParams')) {
            return;
        }

        try {
            /** @var TestConnectionParams $paramDto */
            $paramDto = $this->serializer->deserialize($request->getContent(), TestConnectionParams::class, 'json');
            if (!$paramDto->getPassword()) {
                $paramDto->setPassword(\Configuration::get('FF_PASSWORD'));
            }
            $request->attributes->set('testParams', $paramDto);
        } catch (\Exception $e) {
            return;
        }
    }
}
