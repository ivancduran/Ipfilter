IpFilter
==================

Library for filter ips in site


Installation & Configuration
-------------

To install

    ppm install ipfilter


example to add library:
	
	$di->set('ipfilter', function () {
	    $ips = ['198.140.5.38','198.140.5.39','127.0.0.1'];
	    $filter = new Ipfilter\Ipfilter($ips);
	    return $filter;
	});


ips can accept ranges for all ips:
	
	$di->set('ipfilter', function () {
	    $ips = ['198.140.5.38/24','198.140.5.39/32'];
	    $filter = new Ipfilter\Ipfilter($ips);
	    return $filter;
	});


execute in controller

	// return true or false if your ip is in the list
	$this->ipfilter->filter();