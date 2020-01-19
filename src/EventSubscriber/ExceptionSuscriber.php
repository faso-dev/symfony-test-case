<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionSuscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;

    /**
     * ExecptionSubscriber constructor.
     * @param \Swift_Mailer $mailer
     * @param string $from
     * @param string $to
     */
    public function __construct(\Swift_Mailer $mailer, string $from, string $to) {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->to = $to;
    }

    public function onException(ExceptionEvent $event)
    {
        $message = (new \Swift_Message())
        ->setFrom($this->from)
        ->setTo($this->to)
        ->setBody("{$event->getRequest()->getUri()} 
        
        {$event->getException()->getMessage()} 
        
        {$event->getException()->getTraceAsString()}")
        ;
        $this->mailer->send($message);
    }

    public static function getSubscribedEvents()
    {
        return [
            ExceptionEvent::class => 'onException',
        ];
    }
}
