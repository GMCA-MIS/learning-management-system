<?php
include('teacher_session.php');
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('dbcon.php');
?>

<style>
    .custom-container {
        border: 1px solid #ccc;
        padding: 20px;
        margin-top: 20px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        color: black;
    }

    /* Remove the anchor hover effect */
    a:hover {
        text-decoration: none; /* Remove underline on hover */
        color: inherit; /* Inherit the text color from the parent element */
    }

    a {
        text-decoration: none; /* Remove underline */
        color: gray; /* Set the text color to black */
    }

    .icon {
        font-size: 24px;
        position: relative;
        animation: shakeIcon 3s ease infinite;
        transform-origin: center;
    }

    @keyframes shakeIcon {
        0% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(-20deg);
        }
        50% {
            transform: rotate(0deg);
        }
        75% {
            transform: rotate(20deg);
        }
        100% {
            transform: rotate(0deg);
        }
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

        <div class="d-sm-flex align-items-center justify-content-end mb-4">
    <div class="d-sm-flex align-items-center justify-content-end mb-4">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                aria-label="Search" name="search" aria-describedby="basic-addon2" id="search-input">
            <div class="input-group-append">
                <button class="btn primarybtn-new" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input');
        const bookCards = document.querySelectorAll('.col-lg-2');
        const noMatchingBooksAlert = document.getElementById('no-matching-books');

        searchInput.addEventListener('input', function () {
            const searchText = searchInput.value.toLowerCase();

            let anyBooksMatch = false;

            bookCards.forEach(function (card) {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                const author = card.querySelector('.card-text').textContent.toLowerCase();
                const cardVisible = title.includes(searchText) || author.includes(searchText);
                card.style.display = cardVisible ? 'block' : 'none';

                if (cardVisible) {
                    anyBooksMatch = true;
                }
            });

            if (anyBooksMatch) {
                noMatchingBooksAlert.style.display = 'none';
            } else {
                noMatchingBooksAlert.style.display = 'block';
            }
        });
    });
</script>


            <?php
            include("dbcon.php");

            $category_id = $_GET['id'];

            // Query to retrieve category_name based on category_id
            $query = "SELECT * FROM category WHERE category_id = $category_id";

            $result = mysqli_query($conn, $query);

            if ($result) {
                // Check if there are any results
                if (mysqli_num_rows($result) > 0) {
                    // Fetch the category_name
                    $row = mysqli_fetch_assoc($result);
                    $category_name = $row['category_name'];
                } else {
                    echo '<script>window.location.href = "../deny.php";</script>';
                    exit;
                }
            } else {
                echo '<script>window.location.href = "../deny.php";</script>';
                exit;
            }
            ?>

<?php
// Establish a database connection (assuming you have already done this)
include("dbcon.php");

// Retrieve the category name from the URL and decode it
$category_id = $_GET['id'];

// Use prepared statements to prevent SQL injection
$query = "SELECT * FROM booklist WHERE category_id = ?";
$stmt = mysqli_prepare($conn, $query);

// Bind the parameter to the query
mysqli_stmt_bind_param($stmt, "s", $category_id);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Initialize an array to store book covers
$bookCovers = [];

// Check if there are any matching records
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookCovers[] = $row['book_cover'];
        $book_title = $row['book_title'];
        $book_id = $row['book_id'];
    }
}

// Now $bookCovers array contains all the book covers for the specified category
?>

<a href = "library.php" class="btn btn-success">Back</a>
<!-- Content Row -->
<div class="row justify-content-center">
    <div class="col-12 text-center mb-4">
        <h1 style="color: black;" class="mb-3"><?php echo $category_name; ?></h1>
    </div>
</div>

<?php
// Assuming you have already connected to the database and set up your $category_id
// Fetch the book details from the database
$sql = "SELECT * FROM booklist WHERE category_id = $category_id";
$result = mysqli_query($conn, $sql);

$bookDetails = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookDetails[] = $row;
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!-- Your existing code for the cards layout -->
<div class="row">
    <?php
    if (empty($bookDetails)) {
    ?>
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                <center>No books in this category.</center>
            </div>
        </div>
    <?php
    } else {
        foreach ($bookDetails as $bookDetail) {
            $book_id = $bookDetail['book_id'];
            $book_title = $bookDetail['book_title'];
            $bookCover = $bookDetail['book_cover'];
            $author = $bookDetail['author'];
            $publication_year = $bookDetail['publication_year'];
    ?>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                <a href="view_book.php?book_id=<?php echo $book_id; ?>" style="text-decoration: none;">
                    <div class="card border-0">
                        <img src="<?php echo $bookCover; ?>" class="card-img-top" alt="Book Cover" style="max-height: 400px; object-fit: cover;">
                        <div class="card-body">
                            <!-- Add any book details you want here -->
                            <center><h5 class="card-title" style = "color: black;"><?php echo $book_title ?></h5>
                            <p class="card-text"> <?php echo $author ?> </p>
                            <p class="card-text"><?php echo $publication_year ?> </p></center>
                        </div>
                    </div>
                </a>
            </div>
    <?php
        }
    }
    ?>
</div>




<div class="alert alert-warning" role="alert" id="no-matching-books" style="display: none;">
    <center>No books match.</center>
</div>

</div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
