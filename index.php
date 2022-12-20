<?php
require 'config.php.inc';

$output = fopen('php://output', 'w');
if (isset($filename)) {
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename="' . $filename . '"');
} else {
	header('Content-Type: text/plain; charset=utf-8');
}
header('Pragma: no-cache');
header('Expires: 0');

$connection = new mysqli($host, $username, $password, $dbname, $port);
$connection->set_charset("utf8mb4");
$result = $connection->query($sql);

$headers = array();
while ($fieldinfo = $result->fetch_field()) {
	$headers[] = $fieldinfo->name;
}
fputcsv($output, $headers, $separator ?? ',');
while ($row = $result->fetch_array(MYSQLI_NUM)) {
	fputcsv($output, array_values($row), $separator ?? ',');
}

