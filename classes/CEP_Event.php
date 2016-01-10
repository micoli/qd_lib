<?php
use \Symfony\Component\EventDispatcher\Event;

class CEP_Event extends Event{
	protected $data;
	protected $dataAdd;

	public function __construct($data=null,$dataAdd=null){
		$this->data = $data;
		$this->dataAdd = $dataAdd;
	}

	public function setData($data=null){
		$this->data = $data;
	}

	public function getData(){
		return $this->data;
	}

	public function setDataAdd($dataAdd=null){
		$this->dataAdd = $dataAdd;
	}

	public function getDataAdd(){
		return $this->dataAdd;
	}
}