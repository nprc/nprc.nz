<?php
$files = array();
$url = "https://nprc.blob.core.windows.net/sermons?restype=container&comp=list";
$xmlString = file_get_contents($url);

if ($xmlString !== false) {
	// Parse the XML response
	$xml = simplexml_load_string($xmlString);

	$files = array();
	if (isset($xml->Blobs->Blob)) {
		foreach ($xml->Blobs->Blob as $blob) {
			$files[] = (string)$blob->Name;
		}
	}

	rsort($files);
}

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
    $ext = strtolower(substr($file, -4));
    if ($ext === '.mp3' || $ext === '.pdf')
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
