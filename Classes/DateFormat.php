<?php
/**

*/
class DateFormat
{
	protected $connection;

	public function __construct(PDO $connection) {
		$this->connection = $connection;
	}

	public function getTimeAgo($ptime) {
		$estimate_time = time() - $ptime;

		if($estimate_time < 1) {
			return 'Less than a second ago';
		}

		$condition = array(
			12 * 30 * 24 * 60 * 60 => 'year',
			30 * 24 * 60 * 60 => 'month',
			24 * 60 * 60 => 'day',
			60 * 60 => 'hour',
			60 => 'munite',
			1 => 'second'
		);

		foreach($condition as $secs => $str) {
			$d = $estimate_time / $secs;
			if($d >= 1) {
				$r = round($d);
				if($r > 1) {
					return 'Posted about '.$r.' '.$str.'s ago';
				} else {
					return 'Posted about '.$r.' '.$str.' ago';
					//return 'Posted Yesterday';
				}
			}
		}
	}


	function getDate($date) {
		$new_time = strftime("%a %b %d, %Y at %H:%M", strtotime($date));
		return $new_time;
	}



	function time_elapsed_string($datetime, $full = false) {
    	$now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}


	function timeAgo($time_ago)
	{
	    $time_ago = strtotime($time_ago);
	    $cur_time   = time();
	    $time_elapsed   = $cur_time - $time_ago;
	    $seconds    = $time_elapsed ;
	    $minutes    = round($time_elapsed / 60 );
	    $hours      = round($time_elapsed / 3600);
	    $days       = round($time_elapsed / 86400 );
	    $weeks      = round($time_elapsed / 604800);
	    $months     = round($time_elapsed / 2600640 );
	    $years      = round($time_elapsed / 31207680 );
	    // Seconds
	    if($seconds <= 60){
	        return "just now";
	    }
	    //Minutes
	    else if($minutes <=60){
	        if($minutes==1){
	            return "1 minute ago";
	        }
	        else{
	            return "$minutes minutes ago";
	        }
	    }
	    //Hours
	    else if($hours <=24){
	        if($hours==1){
	            return "1 hour ago";
	        }else{
	            return "$hours hrs ago";
	        }
	    }
	    //Days
	    else if($days <= 7){
	        if($days==1){
	            return "Yesterday";
	        }else{
	            return "$days days ago";
	        }
	    }
	    //Weeks
	    else if($weeks <= 4.3){
	        if($weeks==1){
	            return "1 week ago";
	        }else{
	            return "$weeks weeks ago";
	        }
	    }
	    //Months
	    else if($months <=12){
	        if($months==1){
	            return "1 month ago";
	        }else{
	            return "$months months ago";
	        }
	    }
	    //Years
	    else{
	        if($years==1){
	            return "1 year ago";
	        }else{
	            return "$years years ago";
	        }
	    }
	}


}

?>