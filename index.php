<?php

// Specify settings and ensure cURL is installed
$url = "http://dl.dropbox.com/u/1844304/data.php";
$output_format = "%s: %d<br />"; // For example: "Larry: 34<br />"
if (!function_exists('curl_init')) {
  exit('Please install cURL and try again.');
}

// (1) use cURL to grab the url
$contents = fetch_contents($url);

// (2) parse JSON data into array
$data = json_decode($contents, true);

// (3) order by name and print each item in the specified format
ksort($data);
echo 'People sorted by name<br />';
print_r_formatted($data, $output_format);

// (4) print the 3 oldest people in the same format
arsort($data);
$oldest = array_slice($data, 0, 3);
echo '<br />Oldest 3 people<br />';
print_r_formatted($oldest, $output_format);

// Functions would usually be in a separate file,
// but for convenience they are below.

/**
* Fetches contents from a webpage using cURL
* @param string $url URL to fetch
* @return string webpage contents
*/
function fetch_contents($url) {

  $curl = curl_init();

  curl_setopt ($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $result = curl_exec ($curl);
  curl_close ($curl);

  return $result;
}

/**
* Prints each item in an array using specified formatting
* @param array $array inputted array
* @param string $format formatting string to use in printf
*/
function print_r_formatted($array, $format) {
  foreach ($array as $key => $value) {
    printf($format, $key, $value);
  }
}

?> 