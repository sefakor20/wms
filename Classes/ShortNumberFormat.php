<?php
/**

*/
class ShortNumberFormat
{
	protected $number;
	
	function __construct($number)
	{
		$this->number = $number;
	}


	//format  
	public function numberFormat() {
		if($this->number > 0 && $this->number < 1000) {
			//1 - 999
			$num_format = floor($this->number);
			$suffix = '';
		} elseif ($this->number >= 1000 && $this->number < 1000000) {
			//1k - 999k
			$num_format = floor($this->number / 1000);
			$suffix = 'K+';
		} elseif ($this->number >= 1000000 && $this->number < 1000000000) {
			//1m - 999m
			$num_format = floor($this->number / 1000000);
			$suffix = 'M+';
		} elseif ($this->number >= 1000000000 && $this->number < 1000000000000) {
			//1b - 999b
			$num_format = floor($this->number / 1000000000);
			$suffix = 'B+';
		} elseif ($this->number >= 1000000000000) {
			//1t+
			$num_format = floor($this->number / 1000000000000);
			$suffix = 'T+';
		}

		return !empty($num_format . $suffix) ? $num_format . $suffix : 0;
	}


}


?>