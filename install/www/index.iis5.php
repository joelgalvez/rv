<?php

// In this prepend file for the index, some server variables are altered to
// make index.php work on IIS5 in tandem with the IIRF rewrite module.

// The Iirf.ini passes the full request uri in the form of a query string to
// this script. So we set REQUEST_URI to this value. Note that IIS doesn't
// set REQUEST_URI in normal operation.
$_SERVER['REQUEST_URI'] = @$_SERVER["QUERY_STRING"];
$pathAndQuery = explode('?', @$_SERVER['QUERY_STRING'], 2);

// Reset some $_SERVER and request related variables so that the code after us
// will be tricked transparently.
$_SERVER["SCRIPT_NAME"] = @$pathAndQuery[0];
if (isset($pathAndQuery[1])){
    $_SERVER["QUERY_STRING"] = $pathAndQuery[1];
}else{
    unset($_SERVER["QUERY_STRING"]);
}

// Repopulate the $_GET array based on the new query string.
$queryParts = explode('&', @$_SERVER["QUERY_STRING"]);
$_GET = array();
foreach ($queryParts as $i=>$part){
    list($name, $value) = explode('=', $part . ((strpos($part, '=') === false) ? '=' : ''), 2); // The added = is there in case the part doesn't contain an = (ie. an empty/flag parameter).
    $_GET[$name] = $_REQUEST[$name] = urldecode($value);
}

require('index.php');

?>