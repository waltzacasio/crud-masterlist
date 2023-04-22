   <!-- create the search engine form -->
    <form action="index.php" method="GET">
        <input type ="text" name="k" value="<?php echo isset($_GET['k']) ? $_GET['k'] : ''; ?>" placeholder="Enter your search keywords" />
        <input type="submit" value="Search" />
    </form>

<?php

    include_once('dbh.inc.php');

// get the search terms from the url

if ($k = isset($_GET['k']) ? $_GET['k'] : '') 

{

// create the base variables for building the search query
//$search_string = "SELECT * FROM gpinoy WHERE ";

/*
Box Brand = barcode1 | barcode2 | barcode3
Gpinoy = Type number | NULL | NULL
GSAT HD = Chip ID | NULL | NULL
Cignal = CCA | STB | Box Type
Satlite = CCA | STB | NULL 
*/

/*
$search_string = "SELECT 1, id, lastName, firstName, addressLocation, boxNumber, barcode1, barcode2, barcode3, remarks, dateOfPurchase, contact, installer FROM cignal 
UNION ALL SELECT 2, id, lastName, firstName, addressLocation, boxNumber,  barcode1, barcode2, barcode3, remarks, dateOfPurchase, contact, installer FROM gpinoy WHERE ";
*/

//gpinoy search string
$search_string = "(SELECT * FROM gpinoy WHERE ";

$display_words = "";

//format each of search keywords into the db query to be run
$keywords = explode(' ', $k);
foreach ($keywords as $word) {
    $search_string .= "CONCAT_WS(' ',`lastName`,`firstName`,`addressLocation`,`boxNumber`,`barcode1`,`barcode2`,`barcode3`,`remarks`,`dateOfPurchase`,`contact`,`installer`) LIKE '%" . $word . "%' AND ";
    $display_words .= $word . ' ';
}
//removing the "AND " from the query.
$search_string = substr($search_string, 0, strlen($search_string) -4);
$search_string .= ")";
//removing the space from the last keyword
 $display_words = substr($display_words, 0, strlen($display_words) -1);


//cignal search string
$cignal_search_string = " UNION (SELECT * FROM cignal WHERE ";

//format each of search keywords into the db query to be run
foreach ($keywords as $word) {
    $cignal_search_string .= "CONCAT_WS(' ',`lastName`,`firstName`,`addressLocation`,`boxNumber`,`barcode1`,`barcode2`,`barcode3`,`remarks`,`dateOfPurchase`,`contact`,`installer`) LIKE '%" . $word . "%' AND ";
}
//removing the "AND " from the query.
$cignal_search_string = substr($cignal_search_string, 0, strlen($cignal_search_string)-4);
$cignal_search_string .= ")";


//connect to the database
//include('connect-db.php');

//run the query in the db and search through each of the records returned
$query = mysqli_query($conn, $search_string . $cignal_search_string);
$result_count = mysqli_num_rows($query);

//display a message to the user to display the keywords
echo '<b><u>' . number_format($result_count) . '</u></b> results found. ';
echo 'Your search for <i>' . $display_words . '</i><hr/>';


} else{
        $result_count = "";
        $search_string = "";
}


?>


