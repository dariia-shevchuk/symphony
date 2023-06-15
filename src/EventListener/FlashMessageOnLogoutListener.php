<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

/**
 * @author Christian Flothmann <christian.flothmann@sensiolabs.de>
 *
 * @final
 */
class FlashMessageOnLogoutListener implements EventSubscriberInterface
{
    public function onLogoutMessage(LogoutEvent $event): void
    {
        $event->getRequest()->getSession()->getFlashBag()->add('success', 'See you later!');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutMessage',
        ];
    }
}
