<?php
use \Symfony\Component\EventDispatcher\Event;
use \Symfony\Component\EventDispatcher\EventDispatcher;

class_exists('Addendum');

class CEP_EventHandler extends Annotation{
	public $event='';
	public $priority=0;
}

class CEP_EventContainer{
	public function __construct(EventDispatcher $EventDispatcher){
		$reflection = new ReflectionAnnotatedClass(get_class ($this));
		foreach($reflection->getMethods() as $method){
			if($method->hasAnnotation('CEP_EventHandler')){
				$annotation = $method->getAnnotation('CEP_EventHandler');
				$EventDispatcher->addListener(
					$annotation->event,
					array($method->class,$method->name),
					$annotation->priority
				);
			}
		}
	}
}