<?php
/**
* Time helper that is smart about timezones, wraps the CakePHP time helper
* Can add other functions from Time as needed
*/
class TimePlusHelper extends AppHelper {
	var $helpers = array("Time");

	function nice($date_string) {
		$offset = $this->_computeOffset(new DateTime($date_string));
		return $this->Time->nice($date_string, $offset);
	}

	function niceShort($date_string) {
		$offset = $this->_computeOffset(new DateTime($date_string));
		// Need to set timezone to be local so the Time helper correctly detects Today/Yesterday in our local time
		date_default_timezone_set(Configure::read("Club.timezone")->getName());
		return $this->Time->niceShort($date_string, $offset);
		date_default_timezone_set('UTC');
	}

	/**
	* Converts a date string to UTC of form 2008-01-21 00:00:00
	*/
	function toSQL($date_string) {
		$offset = -1 * $this->_computeOffset(new DateTime($date_string));
		return $this->Time->format('Y-m-d H:i:s', $date_string, false, $offset);
	}

	/**
	* Returns the current time in SQL format (2008-01-21 00:00:00)
	*/
	function nowSQL() {
		$time = new DateTime();
		$offset = $this->_computeOffset($time);
		return $this->Time->format('Y-m-d H:i:s', $time->format('U'), false, $offset);
	}

	/**
	* Converts a date string from UTC SQL returning the same form (2008-01-21 00:00:00)
	*/
	function fromSQL($date_string) {
		$offset = $this->_computeOffset(new DateTime($date_string));
		return $this->Time->format('Y-m-d H:i:s', $date_string, false, $offset);
	}

	function format($format, $date_string) {
		$offset = $this->_computeOffset(new DateTime($date_string));
		return $this->Time->format($format, $date_string, false, $offset);
	}

	/**
	* Time offset in hours returned
	*/
	function _computeOffset($date) {
		$clubTimezone = Configure::read("Club.timezone");
		// Could look at user timezone here

		return $clubTimezone->getOffset($date)/3600;
	}

	function timeFromParts($hours, $minutes, $seconds) {
		$hours = str_pad($hours, 2, '0');
		$minutes = str_pad($minutes, 2, '0');
		$seconds = str_pad($seconds, 2, '0');

		return $hours . ":" . $minutes . ":" . $seconds;
	}
	
	function ago($datetime) {
	   return "<time class=\"timeago\" datetime=\"".$datetime->format(DateTime::ISO8601)."\">
                ".$datetime->format(DateTime::ISO8601)."
            </time>";
	}
}
?>