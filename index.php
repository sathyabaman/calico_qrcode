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
    <title>QR Code</title>
</head>
<body>
<table>
                <colgroup>
                    <col class="col1" />
                    <col class="col2" />
                </colgroup>
                <tbody>
                    <THEAD style="background: orange;">
                        <tr>
                            <td>Barcode #</td>
                            <td>CTN #</td>
                            <td>PI #</td>
                            <td>PO #</td>
                            <td>IM #</td>
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


                        <a href="qrcodegenerator.php?ctnid=<?php echo $package["ctn"]; ?>">
                            <button type="button" style="background: orange;">click Here</button>
                        </a>

                        </td>
                    </tr>
                   
                <?php endforeach;?>
                </tbody>
               
            </table>


<a href="login/login/logout.php" class="btn btn-default btn-lg btn-block">Logout</a>

</body>
</html>
