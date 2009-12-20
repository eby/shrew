<?php

require_once('InnopacWeb.php');

 ############################################
 #                                          #
 #  SIMPLE TEST SCRIPT FOR INNOPACWEB CLASS #
 #                                          #
 ############################################

// server defines the location of the iii system you are attempting to access
// enter as: catalog.yourlib.edu

$server = "http://" . $_GET["server"];

// innreach defines whether the iii system is an innreach server or not
// this will tell the class to parse holdings data slightly differently

$innreach = array_key_exists("innreach", $_GET);

// you can specify either a bibliographic id number (in a parameter called 'id')
// or you can search on a specific index (in param called 'index') using a supplied
// query (in a param called 'query'). e.g., index = 't' and query = 'catcher in the rye'
// will do a title search for catcher in the rye

$id = ""; if ( array_key_exists("id", $_GET) ) $id = $_GET["id"];
$index = ""; if ( array_key_exists("index", $_GET) ) $index = $_GET["index"];
$query = ""; if ( array_key_exists("query", $_GET) ) $query = $_GET["query"];


// do something!

$objCatalog = new InnopacWeb($server);
$objCatalog->setInnReach($innreach);

echo "<pre>";

if ( $id != null )
{
	$arrResults = $objCatalog->getRecords($id);
}
elseif ( $query != null and $index != null )
{
	$arrResults = $objCatalog->search($index, $query);
}
	
echo "<h3>found " . $objCatalog->getTotal() . "</h3>";
	
foreach ( $arrResults as $objRecord )
{
	$objRecord->bibliographicRecord->formatOutput = true;
	echo htmlspecialchars($objRecord->bibliographicRecord->saveXML());
	print_r($objRecord->items);
}

echo "</pre>";

?>