<?php

namespace Ipfilter;

use Phalcon\Mvc\User\Component;

class Ipfilter extends Component
{

	public $ips;

	function __construct($ips){
		$this->ips = $ips;
	}

	public function getRealIP()
	{
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))
	        return $_SERVER['HTTP_CLIENT_IP'];
	       
	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	        return $_SERVER['HTTP_X_FORWARDED_FOR'];
	   
	    return $_SERVER['REMOTE_ADDR'];
	}

	private function ipListFromRange($range)
	{
	    $parts = explode('/',$range);
	    $exponent = 32-$parts[1].'-';
	    $count = pow(2,$exponent);
	    $start = ip2long($parts[0]);
	    $end = $start+$count;
	    return array_map('long2ip', range($start, $end) );
	}

	public function filter()
	{
		$ip = $this->getRealIP();
		$valid = false;
		$newArr = array();

		// new Array
		foreach ($this->ips as $iptable) {
			$exp = explode("/", $iptable);
			if (isset($exp[1])){
				$var = $this->ipListFromRange($iptable);
				foreach ($var as $key) {
					$newArr[] = $key;
				}
			}else{
				$newArr[] = $iptable;
			}
			
		}

		$unicArr = array_unique($newArr);
		foreach ($unicArr as $key) {
			if($key === $ip){
				$valid = true;
			}
		}
		return $valid;

	}

}
