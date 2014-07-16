<?php

// In this prepend file for the index, some server variables are altered to
// make index.php work on IIS5 in tandem with the IIRF rewrite module.

// The Iirf.ini passes the full request uri in the form of a query string to
// this script. So we set REQUEST_URI to this value. Note that IIS doesn't
// set REQUEST_URI in normal operation.
$_SERVER['REQUEST_URI'] = $_SERVER["QUERY_STRING"];
$requestParts = parse_url($_SERVER['REQUEST_URI']);

// Reset some $_SERVER and request related variables so that the code after us
// will be tricked transparently.
$_SERVER["SCRIPT_NAME"] = $requestParts['path'];
if (isset($requestParts['query'])){
  $_SERVER["QUERY_STRING"] = $requestParts['query'];
}else{
  unset($_SERVER["QUERY_STRING"]);
}

// Repopulate the $_GET array based on the new query string.
// NOTE: We should also repopulate the $_REQUEST array, shouldn't we? But I'm not
// sure if it will work correctly with uploads...
$queryParts = explode('&', $_SERVER["QUERY_STRING"]);
$_GET = array();
foreach ($queryParts as $i=>$part){
  list($name, $value) = explode('=', $part);
  $_GET[$name] = $value;
}

require('index.php');

?>