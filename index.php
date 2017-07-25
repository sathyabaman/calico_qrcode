<?php 

include('includes/Db.php');
$db = new Db();
$packageList = $db -> getAllPackageList();


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
                            <button class="btn btn-warning" type="button" style="background: orange;">View</button>
                        </a>

                        </td>
                    </tr>
                   
                <?php endforeach;?>
                </tbody>
 </table>

</div>


</body>
</html>
