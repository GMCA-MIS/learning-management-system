<?php 
    include('database-connect/connect.php');
?>

<?php 

    if(ISSET($_POST['request'])){

        $req = $_POST['request'];

        $query = "SELECT * FROM document WHERE Section = '$req'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
?>

<table class="table table-striped">
    <?php 
        if($count){

    ?>
    <thead>
        <tr>
            <th>ID</th>
            <th>Section</th>
            <th>Code</th>
            <th>Filename</th>
            <th>Document Type</th>
        </tr>
        <?php 
        }   else{
                echo "Sorry no data found";
            }
        ?>
    </thead>

    <tbody>
        <?php 
           while($row = mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <td><?php echo $row['Document_ID']; ?></td>
            <td><?php echo $row['Section']; ?></td>
            <td><?php echo $row['Document_Code']; ?></td>
            <td><?php echo $row['Document_Title']; ?></td>
            <td><?php echo $row['Document_Type']; ?></td>    
        </tr>
        <?php 
            }
        ?>
    </tbody>
</table>

<?php 
     }
?>

<!-------------------------------- type ------------------------->
<?php 

    if(ISSET($_POST['requestType'])){

        $req = $_POST['requestType'];

        $query = "SELECT * FROM document WHERE Document_Type = '$req'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
?>

<table class="table table-striped">
    <?php 
        if($count){

    ?>
    <thead>
        <tr>
            <th>ID</th>
            <th>Section</th>
            <th>Code</th>
            <th>Filename</th>
            <th>Document Type</th>
        </tr>
        <?php 
        }   else{
                echo "Sorry no data found";
            }
        ?>
    </thead>

    <tbody>
        <?php 
           while($row = mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <td><?php echo $row['Document_ID']; ?></td>
            <td><?php echo $row['Section']; ?></td>
            <td><?php echo $row['Document_Code']; ?></td>
            <td><?php echo $row['Document_Title']; ?></td>
            <td><?php echo $row['Document_Type']; ?></td>    
        </tr>
        <?php 
            }
        ?>
    </tbody>
</table>

<?php 
     }
?>


