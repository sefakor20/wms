<?php
class Filter
{
	protected $connection;

	protected $content;

	public function __construct(PDO $connection) {
		$this->connection = $connection;
	}


	//filter for output
	public function filterOutput($content) {
		$content = htmlentities($content, ENT_NOQUOTES);
	    $content = nl2br($content, false);
	    return $content;
	}


	//reduce article length for read more option
	public function shortLength($content, $number_of_characters) {
		$article_length = strlen($this->filterOutput($content));
		if($article_length > $number_of_characters) {
			//setting new length
			$this->content = substr($content, 0, $number_of_characters).'...';
		} else {
			$this->content = $content;
		}
		return $this->content;
	}


}

?>