<?php
    include_once('header.php'); 
    include_once('includes/dbh.inc.php');
?>

<?php

//get page number
if (isset($_GET['page_no']) && $_GET['page_no'] !== "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

//total rows or records to display
$total_records_per_page = 10;
//get the page offset for the LIMIT query
$offset = ($page_no - 1) * $total_records_per_page;
//get previous page
$previous_page = $page_no - 1;
//get the next page
$next_page = $page_no + 1;
         


//get the total count of records
$result_count = mysqli_query($conn, "SELECT * FROM deletelogs UNION SELECT * FROM editlogs;") or die(mysqli_error($mysqli));
$rowcount=mysqli_num_rows($result_count);

//get total pages
$total_no_of_pages = ceil($rowcount / $total_records_per_page);
//pagination range
$pagination_range = 2;

//query string
$sql = "SELECT 1, lastName, firstName, addressLocation, boxNumber, remarks, dateOfPurchase, contact, installer, dateAndTime, userName, info FROM editlogs UNION ALL SELECT 2, lastName, firstName, addressLocation, boxNumber, remarks, dateOfPurchase, contact, installer, dateAndTime, userName, info FROM deletelogs ORDER BY dateAndTime DESC LIMIT $offset , $total_records_per_page";
// result
$query = mysqli_query($conn, $sql) or die(mysqli_error($sql));

?>

<h1> LOGS</h1>

<!-- Body -->

<div class="container mt-5">

<!-- Table Start -->
<table class="table">

<div class="p-10">
    <strong>Page <?= $page_no; ?> of <?= $total_no_of_pages; ?></strong>
</div>
<nav aria-label="Page navigation example">
    <ul class="pagination">

        <li class="page-item"><a class="page-link <?= ($page_no <= 1) ? 'disabled' : ''; ?> " <?= ($page_no > 1) ? 'href=?page_no=' . $previous_page : ''; ?>>Previous</a></li>


        <?php for ($counter = ($page_no - $pagination_range); $counter <= ($page_no + $pagination_range); $counter++) { ?>

            <?php if (($counter > 0) && ($counter <= $total_no_of_pages)) { ?>

            <?php if ($page_no != $counter) { ?>
                <li class="page-item"><a class="page-link" href="?page_no=<?= $counter; ?>"><?= $counter; ?></a></li>
            <?php } else { ?>
                <li class="page-item"><a class="page-link active"><?= $counter; ?></a></li>

                <?php } ?>
            <?php } ?>
        <?php } ?>

        <li class="page-item"><a class="page-link <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>" <?= ($page_no < $total_no_of_pages) ? 'href=?page_no=' . $next_page : ''; ?>>Next</a></li>
    </ul>
</nav>
</div>
    <thead>
        <tr>
            <th>Type</th>
            <th>Box Number</th>
            <th>Details</th>
            <th>Time</th>
            <th>Info</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_array($query)) { ?>
            <tr>
                <td><?php if ($row['1'] == 1 ) {echo "Edited";} else {echo "Deleted";}?></td>
                <td><?= $row['boxNumber']; ?></td>
                <td>                
                    <?php 
                    if ($row['1'] == 1) {
                        echo "Previous Value:<br>";
                        if(isset($row['firstName']))  {echo "First Name=" . $row['firstName'] . "<br>";}
                        if(isset($row['lastName']))  {echo "Last Name=" . $row['lastName'] . "<br>";}
                        if(isset($row['addressLocation']))  {echo "Address=" . $row['addressLocation'] . "<br>";}
                        if(isset($row['remarks']))  {echo "Remarks=" . $row['remarks'] . "<br>";}
                        if(isset($row['dateOfPurchase']))  {echo "Purchase Date=" . $row['dateOfPurchase'] . "<br>";}
                        if(isset($row['contact']))  {echo "Contact=" . $row['contact'] . "<br>";}
                        if(isset($row['installer']))  {echo "Installer=" . $row['installer'] . "<br>";} 
                    } else if ($row['1'] == 2) 
                    {echo $row['firstName'] . " " . $row['lastName'] . " ; " . $row['addressLocation'] . " ; " . $row['remarks'] . " ; " . $row['dateOfPurchase'] . " ; " . $row['contact'] . " ; " . $row['installer'];}
                   
                    ?>
                </td>
                <td><?= $row['dateAndTime']; ?></td>
                <td><?= $row['info']; ?></td>
                <td><?= $row['userName']; ?></td>



            </tr>




</div>
</div>
</div>

        <?php }
        mysqli_close($conn) ?>
    </tbody>
</table>

        </div>

<?php 
    include_once('footer.php');
?>