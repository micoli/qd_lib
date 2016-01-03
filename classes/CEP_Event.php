<?php
use \Symfony\Component\EventDispatcher\Event;

class CEP_Event extends Event{
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