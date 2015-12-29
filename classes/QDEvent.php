<?php
use \Symfony\Component\EventDispatcher\Event;

class QDEvent extends Event{
	protected $data;

	public function __construct($data=null){
		$this->data = $data;
	}

	public function setData($data=null){
		$this->data = $data;
	}

	public function getData(){
		return $this->data;
	}
}