<?php
/**
 * Stupid simple dispatcher 
 */
$url = parseurl();

/**
 * Takes a url (or the current one) and "parses" it. Everything after
 * the first `/` is considered a param
 * 
 * @param string $url
 * @return array 
 */
function parseurl($url = null) {
	if (!$url) {
		$url = $_GET['url'];
	}
	$host = $_SERVER['HTTP_HOST'];
	$path = trim(str_replace($_GET['url'], '', $_SERVER['REQUEST_URI']), '/');
	$parsed = parse_url($path);
	$url = explode('/', $_GET['url']);
	$url = array_filter($url);
	if (empty($url)) {
		$url = array(
			'home'
		);
	}
	return array(
		'base' => "http://$host/{$parsed['path']}",
		'page' => $url[0],
		'params' => array_slice($url, 1)
	);
}

/**
 * Quick redirect helper
 * 
 * @param string $location
 */
function redirect($location) {
	global $url;
	$location = trim($location, '/');
	if ($location === '404') {
		header("Location: {$url['base']}/$location");
		exit();
	}
	header("Location: {$url['base']}/$location");
	exit();
}

/**
 * Fairly useless debug function
 * 
 * @param mixed $obj 
 */
function debug($obj) {
	$out = null;
	if (is_string($obj)) {
		$out = $obj;
	} else {
		$out = var_export($obj, true);
	}
	echo "<pre>$out</pre>";
}

if (!file_exists($url['page'].'.php')) {
	redirect('404');
}

require $url['page'].'.php';