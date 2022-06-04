<?php
// Get the list of files from object storage
$json = file_get_contents('https://objectstorage.ap-sydney-1.oraclecloud.com/n/sd80me0per9s/b/nprc/o/');
$file_data = json_decode($json);

$files = array();
foreach ($file_data->objects as $d)
{
	  $files[] = $d->name;   
}
rsort($files);

// Display the header
date_default_timezone_set('Pacific/Auckland'); 
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="utf-8" standalone="yes"?>';
echo '<rss version="2.0">';
echo '<channel>';
echo '<title>New Plymouth Reformed Church Sermons</title>';
echo '<link>https://nprc.nz/sermons.html</link>';

// Display the files
foreach ($files as $file)
{
	if (substr(strtolower($file), -4) == '.mp3' || substr(strtolower($file), -4) == '.pdf')
	{
		echo '<item><title>';
		echo substr($file, 0, -4);
		echo '</title><pubDate>';
		echo date('r', strtotime(substr($file, 0, 10)));
		echo '</pubDate><link>https://nprc.nz/sermons/';
		echo htmlentities($file);
		echo '</link></item>';
	}
}

// Display the footer
echo '</channel></rss>';
