<?php namespace Helpers;

class Results {

	public $success_count;
	public $fail_count;
	public $class_type;
	public $failure = array();
	
	public function __construct(){
		$this->success_count = 0;
		$this->fail_count = 0;
		$this->class_type = null;
	}

	public function Count(){
		return $this->success_count + $this->fail_count;
	}

	public function SuccessRate(){
		return round(($this->success_count * 1.0) / $this->Count() * 100.0, 2);
	}

}

?>