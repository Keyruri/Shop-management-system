<?php
include 'protect.php';
include 'protect-admins.php';
require 'connect.php';
$sql = "SELECT 
        customers.names AS customer, products.title, products.price, sales.date_sold, users.names AS user
        FROM customers
        JOIN sales ON customers.id = sales.customer_id
        JOIN products ON products.id = sales.product_id
        JOIN users ON users.id = sales.user_id ORDER BY sales.date_sold DESC";

if (isset($_GET["start_date"]) and  isset($_GET["end_date"]))
{
    $start = $_GET["start_date"];
    $end = $_GET["end_date"];

    $sql = "SELECT 
        customers.names AS customer, products.title, products.price, sales.date_sold, users.names AS user
        FROM customers
        JOIN sales ON customers.id = sales.customer_id
        JOIN products ON products.id = sales.product_id
        JOIN users ON users.id = sales.user_id 
        WHERE sales.date_sold BETWEEN '$start' AND '$end'
        ORDER BY sales.date_sold DESC";
}

$result = mysqli_query($con, $sql) or die(mysqli_error($con));// executing the query
$rows = mysqli_fetch_all($result, 1);//assoc array
mysqli_close($con);//close the connection
//customer, title, cost, date, person

$total = 0;
foreach ($rows as $item){
    $total += $item["price"] * 1;
}
//last 7 days report
  $today = date('Y-m-d');
$last_seven =date('Y-m-d', strtotime('-7 days'));
$last_thirty = date('Y-m-d', strtotime('-30 days'));

$last_two = date('Y-m-d', strtotime('-14 days'));
$last_six = date('Y-m-d', strtotime('-6 months'));


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    <link rel="stylesheet" href="CSS/bootstrap1.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>
<body>

<?php include 'nav.php' ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">

            <form action="reports.php" method="get" class="form-inline mt-2 mb-3">

                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" max="<?=date("Y-m-d")?>" value="2021-01-01" class="form-control" name="start_date">
                </div>

                <div class="form-group ml-3">
                    <label>End Date</label>
                    <input type="date" max="<?=date("Y-m-d")?>" value="<?=date("Y-m-d")?>" class="form-control" name="end_date">
                </div>

                <button class="btn btn-info ml-3">Filter</button>

                <button type="reset" class="btn btn-dark ml-3">Clear</button>

            </form>
            <a class="btn btn-sm btn-info" href="reports.php?start_date=<?= $last_seven?>$end_date=<?=$today?>">Report For Last Seven Days</a>
            <a class="btn btn-sm btn-info" href="reports.php?start_date=<?= $last_two?>$end_date=<?=$today?>">Report For Last Two Weeks</a>
            <a class="btn btn-sm btn-info" href="reports.php?start_date=<?= $last_thirty?>$end_date=<?=$today?>">Report For Last Thirty Days</a>
            <a class="btn btn-sm btn-info" href="reports.php?start_date=<?= $last_six?>$end_date=<?=$today?>">Report For Last Six Months</a>

            <h4 class="text-success">Total Sales is Ksh <?=$total?> </h4>

            <table id="example" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Customer</th>
                    <th>Title</th>
                    <th>Cost</th>
                    <th>User</th>
                    <th>Date</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($rows as $data): ?>
                    <tr>
                        <td> <?= $data["customer"] ?> </td>
                        <td> <?= $data["title"] ?> </td>
                        <td> <?= $data["price"] ?> </td>
                        <td> <?= $data["user"] ?> </td>
                        <td> <?= $data["date_sold"] ?> </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

                <tfoot>
                <tr>
                    <th></th>
                    <th>Totals </th>
                    <th class="total"></th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>

            </table>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.24/api/sum().js"></script>

<script>
    /*  $(document).ready(function () {
          $('#example').DataTable();
      });*/
    $('#example').DataTable( {
        drawCallback: function () {
            var api = this.api();
            $('.total').html(
                api.column( 2, {page:'current'} ).data().sum()
            );
        }
    }); //
</script>

</body>
</html>
