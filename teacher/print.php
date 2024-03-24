<?php
$con = mysqli_connect('localhost', 'root', '', 'capstone');
$res = mysqli_query($con, "select * from student");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dynamic Datatable</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome CSS -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">

  <!-- DataTables.net Buttons CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

  <!-- DataTables.net Buttons CSS (Additional) -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.4/css/select.dataTables.min.css">

  <!-- Custom styles -->
  <link rel="stylesheet" type="text/css" href="css/sb-user.css?<?php echo time(); ?>">
  <link rel="stylesheet" type="text/css" href="css/newheader.css?<?php echo time(); ?>">

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- DataTables.net JS -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <!-- DataTables.net Bootstrap 4 JS -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

  <!-- DataTables.net Buttons JS -->
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script> <!-- Include pdfmake -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script> <!-- Include vfs_fonts.js -->
  <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>

  <style>
    /* Custom button styles */
    .dt-buttons {
      margin-bottom: 10px;
    }

    .dt-button {
      background-color: #007bff;
      color: #ffffff;
      border: 1px solid #007bff;
      margin-right: 5px;
    }

    .dt-button:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container" style="margin-top:50px;">
  <table class="table table-striped" id="dataTable">
    <thead>
      <tr>
        <th>Company Name</th>
        <th>Name</th>
        <th>Title</th>
        <th style="display:none;">Address</th>
        <th>City</th>
      </tr>
    </thead>
    <tbody>
      <?php mysqli_data_seek($res, 0); // Reset the result set pointer to the beginning ?>
      <?php while($row=mysqli_fetch_assoc($res)){?>
      <tr>
        <td><?php echo $row['company_name']?></td>
        <td><?php echo $row['name']?></td>
        <td><?php echo $row['title']?></td>
        <td style="display:none;"><?php echo $row['address']?></td>
        <td><?php echo $row['city']?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
    $('#dataTable').DataTable({
      dom: 'lBfrtip',
      buttons: [
        'csv', 'excel', 'pdf'
      ]
    });
  });
</script>

</body>
</html>
