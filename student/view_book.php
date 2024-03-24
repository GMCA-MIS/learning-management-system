<?php 
include('student_session.php');
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('dbcon.php');
?>

<style>
.book-details {
    padding: 20px;
    border: 2px solid #ccc;
    background-color: #f9f9f9;
}

.author {
    font-weight: bold;
    color: black;
    font-size: 36px;
}

.category, .publication-year, .call-number, .book-status {
    margin-top: 10px;
    color: black;
}

.book-description {
    margin-top: 10px;
    font-style: italic;
    color: black;
}

.btn {
    margin-top: 20px;
    color: black;
}

    </style>
        
<style>

.book-cover {
    border: 2px solid #000; /* You can adjust the border width and color */
    padding: 10px; /* Optional padding to create some space around the image */
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); /* Optional box shadow for a raised effect */
}

</style>




        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                
                 <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                        <h1 class="h3 mb-0 text-gray-800"> <i class="fas fa-book-reader icon"></i> Open Online E-Library</h1>
                    </div>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

            


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                
                <?php
include("dbcon.php");

$book_id = $_GET['book_id'];
$query = "SELECT bl.*, c.category_name
          FROM booklist bl
          INNER JOIN category c ON bl.category_id = c.category_id
          WHERE bl.book_id = '$book_id' AND book_status = 'Available'";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $book_title = $row['book_title'];
        $author = $row['author'];
        $category_id = $row['category_id'];
        $category_name = $row['category_name'];
        $publication_year = $row['publication_year'];
        $call_number = $row['call_number'];
        $book_status = $row['book_status'];
        $book_cover = $row['book_cover'];
        $book_description = $row['book_description'];
        $file_path = $row['file_path'];
        
    } else {
        echo "<script>window.location.href = '../deny.php';</script>";
    exit;
    }
} else {
    echo "<script>window.location.href = '../deny.php';</script>";
    exit;
}
?>

<!-- HTML content for displaying book details -->
<div class="row justify-content-center">
    <div class="col-12 text-center mb-4">
    <h1 class="text-center mb-3 display-6 font-weight-bold text-uppercase text-dark"><?= $book_title ?></h1>
    </div>
</div>

<div class="row">
<div class="col-lg-6 col-md-12">
    <img src="<?= $book_cover ?>" alt="Book Cover" class="img-fluid book-cover">
</div>
<div class="col-lg-6 col-md-12">
    <div class="book-details">
        <p class="author">Author: <?= $author ?></p>
        <p class="category">Category: <?= $category_name ?></p>
        <p class="publication-year">Publication Year: <?= $publication_year ?></p>
        <p class="book-description">Book Description: <?= $book_description ?></p>

        <!-- Buttons -->
        <a href="javascript:void(0);" onclick="downloadBook('<?= $file_path ?>');" download="<?= $file_path ?>" class="btn btn-success">Download Book</a>
        <a href="<?php echo $file_path; ?>" download="<?php echo $file_path; ?>" class="btn btn-success pdf-link" onclick="scrollToPdfViewer();">Read Book</a>


    </div>
</div>
<iframe id="pdfViewer" style="width: 100%; height: 90vh;" frameborder="0"></iframe> <hr>
                        <button id="closePdfViewer" class="btn btn-success" style="display: none;">Close</button>

<script>
function scrollToPdfViewer() {
    // Get the top position of the iframe
    const iframeTop = document.getElementById("pdfViewer").offsetTop;

    // Scroll to the iframe
    window.scrollTo({
        top: iframeTop,
        behavior: "smooth" // You can remove this line if you don't want smooth scrolling
    });
}
</script>

<script>
function downloadBook(file_path) {
    var a = document.createElement("a");
    a.href = file_path;
    a.download = file_path;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
</script>
                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

                                <!--Add Pop Up Modal -->
                                <div class="modal fade" id="add_bookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Book for Approval</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form class="" action="library-function.php" method="post" enctype="multipart/form-data" name="upload" >
                                                <div class="modal-body">
                                                <div class="form-group">
                                                        <label for="title">Book Title</label>
                                                        <input type="text" class="form-control" id="title" name="title" required placeholder="Enter Book Title">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="desc">Description</label>
                                                        <textarea class="form-control" id="description" name="desc" rows="4" max-length = "5000" required placeholder="Enter Description"></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="author">Author</label>
                                                        <input type="text"  class="form-control" id="author" name="author" placeholder="Enter Author" required>
                                                    </div>

                                                    <div class="form-group">
                                                    <label for "theme">Category</label>
                                                    <select name="category" id="category" class="form-control" required>
                                                        <option value="" disabled selected>Select Category</option>
                                                        <?php
                                                            $query = "SELECT * FROM category ORDER BY category_name ASC";
                                                            $result = mysqli_query($conn, $query);

                                                            // Check if there are any results
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $category_id = $row['category_id'];
                                                                    $category_name = $row['category_name'];
                                                                    // Create an option for each category
                                                                    echo '<option value="' . $category_id . '">' . $category_name . '</option>';
                                                                }
                                                            }
                                                            // Close the database connection
                                                            mysqli_close($conn);
                                                            ?>
                                                    </select>
                                                    </div> 

                                                    <div class="form-group">
                                                        <label for="publication_year">Publication Year</label>
                                                        <input type="number"  class="form-control" id="publication_year" name="publication_year" placeholder="Enter Publication Year" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="call_number">Call Number</label>
                                                        <input type="number"  class="form-control" id="call_number" name="call_number" placeholder="Enter Call Number" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="book_cover">Book Cover Photo:</label>
                                                        <input type="file" name="book_cover" id="book_cover" accept="image/*">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_book" class="btn btn-success">Create</button>
                                                </div>
                                            </form>
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->
                    </div>
        
                        
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>



