<?php

namespace App\Tests\EventSubscriber;

use App\EventSubscriber\ExceptionSuscriber;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class ExceptionSuscriberTest extends TestCase
{
    public function testEventSubscribtion()
    {
        $this->assertArrayHasKey(ExceptionEvent::class, ExceptionSuscriber::getSubscribedEvents());
    }

    public function testOnExceptionSendMail()
    {

        $mailer = $this
            ->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mailer->expects($this->once())->method('send');
        $this->dispatch($mailer);
        //$subscriber->onException($event);
    }

    public function testOnExceptionSendEmailTheAdmin()
    {
        $mailer = $this
            ->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mailer
            ->expects($this->once())
            ->method('send')
            ->with($this->callback(function (\Swift_Message $message) {
                return array_key_exists('faso-dev@gmail.com', $message->getFrom()) &&
                    array_key_exists('faso-dev@protonnmail.ch', $message->getTo());
            }))
        ;
        $this->dispatch($mailer);
    }

    public function testOnExceptionSendEmailWithTheTrace()
    {
        $mailer = $this
            ->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mailer
            ->expects($this->once())
            ->method('send')
            ->with($this->callback(function (\Swift_Message $message) {
                return strpos($message->getBody(), 'ExceptionSuscriberTest') &&
                       strpos($message->getBody(), 'Hello World');
            }))
        ;
        $this->dispatch($mailer);
    }
    /**
     * @param MockObject | \Swift_Mailer $mailer
     */
    private function dispatch($mailer)
    {
        $subscriber = new ExceptionSuscriber($mailer, 'faso-dev@gmail.com', 'faso-dev@protonnmail.ch');
        /** @var KernelInterface $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        $event = new ExceptionEvent($kernel, new Request(), 1, new \Exception('Hello World'));
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($subscriber);
        $dispatcher->dispatch($event);
    }
}
