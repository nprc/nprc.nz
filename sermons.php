<?php
// Get the files
$files = scandir('sermons', SCANDIR_SORT_DESCENDING);

// Display the header
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
		echo date('r', filemtime('sermons/' . $file));
		echo '</pubDate><link>https://nprc.nz/sermons/';
		echo htmlentities($file);
		echo '</link></item>';
	}
}

// Display the footer
echo '</channel></rss>';
