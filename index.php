<?php
    include_once('header.php'); 
?>


<?php
if (isset($_SESSION["username"])) {
        include_once 'includes/search.inc.php'; ?>

<!-- New Record Modal -->
<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Add New</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<form id="newRecord" action="insertcode.php" method="POST">
<div class="modal-body">                
    <div class="form-group">
      <label>First Name</label>
      <input type="text" name="firstName" class="form-control" placeholder="Enter first name">
    </div>

    <div class="form-group">
      <label>Last Name</label>
      <input type="text" name="lastName" class="form-control" placeholder="Enter last name">
    </div>

    <div class="form-group">
      <label>Address</label>
      <input type="text" name="addressLocation" class="form-control" placeholder="Enter address">
    </div>

    <div class="form-group">
      <label>Box Number</label>
      <input type="text" name="boxNumber" class="form-control" placeholder="Enter box number" required>
    </div>

    <div class="form-group">
      <label>Remarks</label>
      <input type="text" name="remarks" class="form-control" placeholder="Enter remarks">
    </div>

    <div class="form-group">
      <label>Date</label>
      <input type="text" name="dateOfPurchase" class="form-control" placeholder="Enter date">
    </div>

    <div class="form-group">
      <label>Contact No.</label>
      <input type="text" name="contact" class="form-control" placeholder="Enter contact no.">
    </div>

    <div class="form-group">
      <label>Installer</label>
      <input type="text" name="installer" class="form-control" placeholder="Enter installer">
    </div>
</div>      
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<button type="submit" name="insertData" class="btn btn-primary">Save changes</button>
</div>
</form>


</div>
</div>
</div>


<!-- New Record Button -->

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">New Record</button>

<?php
//-- START IF STATEMENT WRAPPER, IF THERE IS A SEARCH QUERY.--
if ($k !== "") {     

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
//get total pages
$total_no_of_pages = ceil($result_count / $total_records_per_page);
//pagination range
$pagination_range = 2;

//query string
$search_string . $cignal_search_string .= " LIMIT $offset , $total_records_per_page";
// result
$query = mysqli_query($conn, $search_string . $cignal_search_string) or die(mysqli_error($mysqli));

//print_r($result_count);
//echo $result_count;
echo $search_string . $cignal_search_string;
//echo $_GET["k"];
?>

<!-- Body -->

<div class="container mt-5">


<!-- Table Start -->
<table class="table">

<div class="p-10">
<strong>Page <?= $page_no; ?> of <?= $total_no_of_pages; ?></strong>
</div>
<nav aria-label="Page navigation example">
<ul class="pagination">

    <li class="page-item"><a class="page-link <?= ($page_no <= 1) ? 'disabled' : ''; ?> " <?= ($page_no > 1) ? 'href=?k=' . $_GET["k"] . '&page_no=' . $previous_page : ''; ?>>Previous</a></li>


    <?php for ($counter = ($page_no - $pagination_range); $counter <= ($page_no + $pagination_range); $counter++) { ?>

        <?php if (($counter > 0) && ($counter <= $total_no_of_pages)) { ?>

        <?php if ($page_no != $counter) { ?>
            <li class="page-item"><a class="page-link" href="?k=<?=$_GET["k"];?>&page_no=<?= $counter; ?>"><?= $counter; ?></a></li>
        <?php } else { ?>
            <li class="page-item"><a class="page-link active"><?= $counter; ?></a></li>

            <?php } ?>
        <?php } ?>
    <?php } ?>

    <li class="page-item"><a class="page-link <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>" <?= ($page_no < $total_no_of_pages) ? 'href=?k=' . $_GET["k"] . '&page_no=' . $next_page : ''; ?>>Next</a></li>
</ul>
</nav>
</div>
<thead>
    <tr>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Address</th>
        <th>Box Number</th>
        <th>Remarks</th>
        <th>Date Of Purchase</th>
        <th>Contact</th>
        <th>Installer</th>
        <th>ID</th>
    </tr>
</thead>
<tbody>
    <?php
    while ($row = mysqli_fetch_array($query)) { ?>
        <tr>
            <td><?= $row['lastName']; ?></td>
            <td><?= $row['firstName']; ?></td>
            <td><?= $row['addressLocation']; ?></td>
            <td><?= $row['boxNumber']; ?></td>
            <td><?= $row['remarks']; ?></td>
            <td><?= $row['dateOfPurchase']; ?></td>
            <td><?= $row['contact']; ?></td>
            <td><?= $row['installer']; ?></td>
            <td><?= $row['id']; ?></td>
            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editRecord<?= $row['id']; ?>">Edit</button>
            <!--<button class="btn btn-danger"><a href="delete.php?deleteID=<// $row['id']; ?>" class="text-light">Delete</a></td> -->
            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteRecord<?= $row['id']; ?>">Delete</button>
        </tr>

<!-- Edit Record Modal -->
<div class="modal" id="editRecord<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Edit Record</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<form id="editRecord" action="edit.php" method="POST">
<div class="modal-body">  
      
<input type="hidden" name="id" value="<?= $row['id']; ?>">
<input type="hidden" name="oldFirstName" value="<?= $row['firstName']; ?>">
<input type="hidden" name="oldLastName" value="<?= $row['lastName']; ?>">
<input type="hidden" name="oldAddressLocation" value="<?= $row['addressLocation']; ?>">
<input type="hidden" name="oldBoxNumber" value="<?= $row['boxNumber']; ?>">
<input type="hidden" name="oldRemarks" value="<?= $row['remarks']; ?>">
<input type="hidden" name="oldDateOfPurchase" value="<?= $row['dateOfPurchase']; ?>">
<input type="hidden" name="oldContact" value="<?= $row['contact']; ?>">
<input type="hidden" name="oldInstaller" value="<?= $row['installer']; ?>">
      
    <div class="form-group">
      <label><b>First Name</b></label>
      <input type="text" name="firstName" class="form-control" placeholder="Enter first name" value="<?= $row['firstName']; ?>">
    </div>

    <div class="form-group">
      <label><b>Last Name</b></label>
      <input type="text" name="lastName" class="form-control" placeholder="Enter last name" value="<?= $row['lastName']; ?>">
    </div>

    <div class="form-group">
      <label><b>Address</b></label>
      <input type="text" name="addressLocation" class="form-control" placeholder="Enter address" value="<?= $row['addressLocation']; ?>">
    </div>

    <div class="form-group">
      <label><b>Box Number</b></label>
      <input class="form-control" id="disabledInput" type="text" placeholder="<?= $row['boxNumber']; ?>" disabled>
    </div>

    <div class="form-group">
      <label><b>Remarks</b></label>
      <input type="text" name="remarks" class="form-control" placeholder="Enter remarks" value="<?= $row['remarks']; ?>">
    </div>

    <div class="form-group">
      <label><b>Date</b></label>
      <input type="text" name="dateOfPurchase" class="form-control" placeholder="YYYY-MM-DD" value="<?= $row['dateOfPurchase']; ?>">
    </div>

    <div class="form-group">
      <label><b>Contact No.</b></label>
      <input type="text" name="contact" class="form-control" placeholder="Enter contact no." value="<?= $row['contact']; ?>">
    </div>

    <div class="form-group">
      <label><b>Installer</b></label>
      <input type="text" name="installer" class="form-control" placeholder="Enter installer" value="<?= $row['installer']; ?>">
    </div>
</div>      
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<button type="submit" name="updateData" class="btn btn-primary">Save changes</button>
</div>
</form>


</div>
</div>
</div>

<!-- Delete Record Modal -->
<div class="modal" id="deleteRecord<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Delete Record</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<form id="deleteRecord" action="delete.php" method="POST">
<div class="modal-body">  
      
<input type="hidden" name="id" value="<?= $row['id']; ?>">
      
<ul class="list-group">
  <li class="list-group-item"><b>First Name: </b><?= $row['firstName']; ?></li>
  <li class="list-group-item"><b>Last Name: </b><?= $row['lastName']; ?></li>
  <li class="list-group-item"><b>Address: </b><?= $row['addressLocation']; ?></li>
  <li class="list-group-item"><b>Box Number: </b><?= $row['boxNumber']; ?></li>
  <li class="list-group-item"><b>Remarks: </b><?= $row['remarks']; ?></li>
  <li class="list-group-item"><b>Date: </b><?= $row['dateOfPurchase']; ?></li>
  <li class="list-group-item"><b>Contact: </b><?= $row['contact']; ?></li>
  <li class="list-group-item"><b>Installer: </b><?= $row['installer']; ?></li>
  <br>
  <div class="form-floating">
    <textarea class="form-control" name="reasonToDelete" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" value ="test" required></textarea>
    <label for="floatingTextarea2">Reason to delete</label>
  </div>
</ul>

</div>      
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<button type="submit" name="deleteData" class="btn btn-primary">Save changes</button>
</div>
</form>


</div>
</div>
</div>

    <?php }
    mysqli_close($conn) ?>
</tbody>
</table>





<nav aria-label="Page navigation example">
<ul class="pagination">

    <li class="page-item"><a class="page-link <?= ($page_no <= 1) ? 'disabled' : ''; ?> " <?= ($page_no > 1) ? 'href=?k=' . $_GET["k"] . '&page_no=' . $previous_page : ''; ?>>Previous</a></li>


    <?php for ($counter = ($page_no - $pagination_range); $counter <= ($page_no + $pagination_range); $counter++) { ?>

        <?php if (($counter > 0) && ($counter <= $total_no_of_pages)) { ?>

        <?php if ($page_no != $counter) { ?>
            <li class="page-item"><a class="page-link" href="?k=<?=$_GET["k"];?>&page_no=<?= $counter; ?>"><?= $counter; ?></a></li>
        <?php } else { ?>
            <li class="page-item"><a class="page-link active"><?= $counter; ?></a></li>

            <?php } ?>
        <?php } ?>
    <?php } ?>



    <li class="page-item"><a class="page-link <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>" <?= ($page_no < $total_no_of_pages) ? 'href=?k=' . $_GET["k"] . '&page_no=' . $next_page : ''; ?>>Next</a></li>
</ul>
</nav>
<div class="p-10">
<strong>Page <?= $page_no; ?> of <?= $total_no_of_pages; ?></strong>
</div>
</div>

<?php } 
//-- END IF STATEMENT WRAPPER, IF THERE IS A SEARCH QUERY.--?>

<?php     } else { ?>

    <h2>Log in</h2>

    <form action="includes/login.inc.php" method="post">
        <input type="text" name="username" placeholder="Username...">
        <input type="password" name="pwd" placeholder="Password...">
        <button type="submit" name="submit">Log In</button>
    </form>

    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Fill in all fields!</p>";
            }
            else if ($_GET["error"] == "wronglogin") {
                echo "<p>Incorrect login information!</p>";
            }
        }
    ?>

<?php } ?>

<?php 
    include_once('footer.php');
?>