<?php
use \Symfony\Component\EventDispatcher\Event;
use \Symfony\Component\EventDispatcher\EventDispatcher;
use \Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;
use \Symfony\Component\Stopwatch\Stopwatch;

class CEP_Interceptor {
	private	$_object;
	private	$_class;
	private	$_rootObject;
	private	$_eventKey=null;
	private	$traceableEventDispatcher	= null;
	private	static	$EventDispatcher	= null;
	private	static	$RawEventDispatcher	= null;
	private	static	$aListeners	= array();
	private	static	$aTraces	= array();
	public	static	$debugEvents= false;

	public function __construct($object,$aPluginClasses=null) {
		$this->_object	= $object;
		$this->_class	= get_class($object);
		$this->_eventKey= (isset($object->dispatchKey))?$object->dispatchKey:$this->_class;

		$this->initEventDispatcher();
		$this->initPlugins($aPluginClasses);

		if($this->hasMethod('attachDispatcher')){
			$object->attachDispatcher(self::$EventDispatcher);
		}

		self::$EventDispatcher->dispatch($this->_eventKey.'.init',new CEP_Event());

		if (is_a($object, "CEP_Interceptor")){
			$this->_rootObject = $object->_rootObject;
		}else{
			$this->_rootObject = $object;
		}

		$object->intercepted = $this;
	}

	public static function addTrace(&$eventName,&$event) {
		self::$aTraces[]=array(
			'e'	=> $eventName,
			't'	=> microtime(true)
		);
	}

	public function debug() {
		return array(
			'traces'			=> self::$aTraces,
			'calledListeners'	=> self::$EventDispatcher->getCalledListeners(),
			'notCalledListeners'=> self::$EventDispatcher->getNotCalledListeners(),
			'listeners'			=> self::$EventDispatcher->getListeners()
		);
	}

	private function initEventDispatcher(){
		if(is_null(self::$EventDispatcher)){
			if(self::$debugEvents){
				self::$RawEventDispatcher	= new CEP_EventDispatcher();
				self::$EventDispatcher		= new TraceableEventDispatcher(
						self::$RawEventDispatcher,
						new Stopwatch()
				);
			}else{
				self::$EventDispatcher		= new CEP_EventDispatcher();
				self::$RawEventDispatcher	= self::$EventDispatcher;
			}
		}
	}

	private function initPlugins($aPluginClasses){
		if(is_array($aPluginClasses)){
			foreach($aPluginClasses as $listenerClass){
				if(!array_key_exists($listenerClass, self::$aListeners))
				self::$aListeners[$listenerClass] = new $listenerClass(self::$RawEventDispatcher);
			}
		}
	}

	public function hasMethod($method){
		return in_array($method,get_class_methods($this->_class));
	}

	public function callMethod($method, $args){
		$methodKey = $this->_eventKey.'.'.preg_replace('!^(pub_|svc_)!','',$method);
		self::$EventDispatcher->dispatch($methodKey.'.pre',new CEP_Event($args));
		$result = call_user_func_array(array($this->_object, $method), $args);
		self::$EventDispatcher->dispatch($methodKey.'.post',new CEP_Event($args));
		return  self::$EventDispatcher->dispatch($methodKey.'.format',new CEP_Event($result))->getData();
	}

	public function __isset($name) {
		return isset($this->_rootObject->$name);
	}

	public function __unset($name) {
		unset($this->_rootObject->$name);
	}

	public function __set($name, $value) {
		$this->_rootObject->$name = $value;
	}

	public function __get($name) {
		return $this->_rootObject->$name;
	}

	public function __call($method, $args) {
		if ($method[0] == "_")
			$method = substr($method, 1);

		return $this->callMethod($method, $args);
	}
}