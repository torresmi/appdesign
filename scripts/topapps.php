<?php
header('Content-Type: text/xml; charset=utf-8');


/***********************************
 * Creates xml of apps and their 
 * ratings 
 ***********************************/
// Get our database
require_once("resources/Database.php");
$db = new Database();

// Create the document
$xml = new DOMDocument('1.0');

// Set properties
$xml->encoding = 'UTF-8';
$xml->formatOutput = true;

$style = $xml->createProcessingInstruction('xml-stylesheet','type="text/xsl" href="style.xsl"');
$xml->appendChild($style); 
$apps = $xml->createElement("apps");

// create a query
$query = "SELECT * FROM apps";

$db->query($query,false);



if ($db->numRows() > 0) {
    foreach($db->rows() as $appData) {

        $app = $xml->createElement('app');
        $appid = $appData['app_id'];
        $name = $xml->createElement('name', $appData['name']);

        // Get the rating data
        $query = "SELECT liked FROM Rating WHERE app_id = $appid AND liked = 1";
        $db->query($query,false);
        $liked = $xml->createElement('liked',$db->numRows());


        $app->appendChild($name);
        $app->appendChild($liked);
        $apps->appendChild($app);
    }
} else {
	echo "error in query database";
}



$xml->appendChild($apps);
echo $xml->saveXMl();
$xml->save('result.xml');
$db->disconnect();
?>