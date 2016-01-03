<?php
use \Symfony\Component\EventDispatcher\Event;
use \Symfony\Component\EventDispatcher\EventDispatcher;

class CEP_EventDispatcher extends EventDispatcher{
	/**
	 * {@inheritdoc}
	 */
	public function dispatch($eventName, Event $event = null){
		if (null === $event) {
			$event = new Event();
		}

		\CEP_Interceptor::addTrace($eventName,$event);

		$event->setDispatcher($this);
		$event->setName($eventName);

		if ($listeners = $this->getListeners($eventName)) {
			$this->doDispatch($listeners, $eventName, $event);
		}

		return $event;
	}
}
