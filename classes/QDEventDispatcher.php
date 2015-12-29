<?php
use \Symfony\Component\EventDispatcher\Event;
use \Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;
use Symfony\Component\Stopwatch\Stopwatch;

class QDEventDispatcher extends EventDispatcher {
	public function dispatch($eventName, Event $event = null){
		//db($eventName);
		if (null === $event) {
			$event = new Event();
		}

		$event->setDispatcher($this);
		$event->setName($eventName);

		if ($listeners = $this->getListeners($eventName)) {
			$this->doDispatch($listeners, $eventName, $event);
		}

		return $event;
	}
}
