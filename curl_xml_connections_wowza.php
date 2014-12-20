<?php

$url = "http://straightcash.co:8086/connectioncounts";
$username = "wowza_earbuzz";
$password = "3v0lve2oo9";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://straightcash.co:8086/connectioncounts');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "wowza_earbuzz:3v0lve2oo9");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
$xml_data = curl_exec($ch);

$doc = new DOMDocument();
$doc->loadXML($xml_data);

$wms = $doc->getElementsByTagName('WowzaStreamingEngine');
$wmstotalactive = $wms->item(0)->getElementsByTagName("ConnectionsCurrent")->item(0)->nodeValue;
$wmstotaloutbytes = $wms->item(0)->getElementsByTagName("MessagesOutBytesRate")->item(0)->nodeValue;
$wmstimerunning = $wms->item(0)->getElementsByTagName("TimeRunning")->item(0)->nodeValue;
$wmstotaloutbits = $wmstotaloutbytes * '8';

echo "<center><b>Hostname:</b> $hostname<br></center><hr> <b>Server Total Active Connections:</b> $wmstotalactive<br> <b>Total Outbound bitrate:</b>  $wmstotaloutbits<br><hr>";

$wmsapp = $doc->getElementsByTagName('Application');
$wmscnt = $wmsapp->length;

echo "<center>Applications</center>";
$emailBody .= "Applications";

for ($idx = 0; $idx < $wmscnt; $idx++) {
	$appname = $wmsapp->item($idx)->getElementsByTagName("Name")->item(0)->nodeValue;
	$appccount = $wmsapp->item($idx)->getElementsByTagName("ConnectionsCurrent")->item(0)->nodeValue;
	$appoutbytes = $wmsapp->item($idx)->getElementsByTagName("MessagesOutBytesRate")->item(0)->nodeValue;
	$appoutbits = $appoutbytes * '8';

	echo "<hr><b>Application Name:</b> $appname<br><b> Active Connections:</b> $appccount<br> <b>Application Bits Out:</b> $appoutbits
	<br>";
}
echo "<hr><center>Streams</center>";
$emailBody .= "\n Streams";
$wmsast = $doc->getElementsByTagName('Stream');
$wmsasct = $wmsast->length;

for ($sidx = 0; $sidx < $wmsasct; $sidx++)  {
	$strname = $wmsast->item($sidx)->getElementsByTagName("Name")->item(0)->nodeValue;
	$strcuperino = $wmsast->item($sidx)->getElementsByTagName("SessionsCupertino")->item(0)->nodeValue;
	$strctot = $wmsast->item($sidx)->getElementsByTagName("SessionsTotal")->item(0)->nodeValue;

	echo "<hr><b>Stream URL:</b> $strname <br> <b>Connections to Stream:</b> $strctot<br>";
}

?>
