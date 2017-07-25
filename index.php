<?php 

include('includes/Db.php');
$db = new Db();
$packageList = "";


session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login/index.php');
}



?>

<!DOCTYPE html>
<html>
<head>
<link href="login/css/bootstrap.css" rel="stylesheet" media="screen">
    <title>QR Code</title>
</head>
<body>
<div>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Calico</a>
    </div>
    <a href="login/login/logout.php" class="btn btn-link pull-right" style=" padding-top: 10px; ">Logout</a>
  </div>
</nav>

</div>
<div class="container">

<?php


try {
    // Find out how many items are in the table
    $total = $db -> totalNoOfitems();
     // How many items to list per page
    $limit = 4;
    // How many pages will there be
    $pages = ceil($total / $limit);
    // What page are we currently on?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));

    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;

    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);

    // The "back" link
    $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    // The "forward" link
    $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    // Display the paging information
    echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';

    // Prepare the paged query
    $stmt = $db -> paginationFetchData($limit, $offset);
    $packageList = $stmt;
    // Do we have any results?
    if (count($stmt) > 0) {
    } else {
        echo '<p>No results could be displayed.</p>';
    }

} catch (Exception $e) {
    echo '<p>', $e->getMessage(), '</p>';
}

?>


    <table class="table table-bordered table-hover">
                    <colgroup>
                        <col class="col1" />
                        <col class="col2" />
                    </colgroup>
                    <tbody>
                        <THEAD style="background: orange;">
                            <tr>
                                <td>Barcode </td>
                                <td>CTN</td>
                                <td>PI </td>
                                <td>PO </td>
                                <td>IM </td>
                                <td>Length</td>
                                <td>Details</td>

                            </tr>
                        </THEAD>
                   
                   <?php foreach($packageList as $package):?>
                        <tr>
                            <td><?php echo $package["barcode"]; ?></td>
                            <td><?php echo $package["ctn"]; ?></td>
                            <td><?php echo $package["pi"]; ?></td>
                            <td><?php echo $package["po"]; ?></td>
                            <td><?php echo $package["im"]; ?></td>
                            <td><?php echo $package["length"]; ?></td>
                            <td>


                            <a href="qrcodegenerator.php?ctnid=<?php echo $package["ctn"]; ?>" style=" text-align: center; display: block; ">
                                <button class="btn btn-warning" type="button" style="background: orange;">QR-Code</button>
                            </a>

                            </td>
                        </tr>
                       
                    <?php endforeach;?>
                    </tbody>
     </table>

</div>

</body>
</html>
