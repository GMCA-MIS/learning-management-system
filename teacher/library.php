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

        .slider-wrapper {
            position: relative;
            display: flex;
            overflow: hidden;
            justify-content: center;
    align-items: center;
        }

        .slider-wrapper .slide-button {
    position: absolute;
    top: 50%;
    outline: none;
    border: none;
    height: 50px;
    width: 50px;
    z-index: 5;
    color: #fff;
    display: flex;
    cursor: pointer;
    font-size: 2.2rem;
    background: #000;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transform: translateY(-50%);
}

.slider-wrapper .slide-button:hover {
    background: #404040;
}

.slider-wrapper .slide-button.left {
    left: -25px;

}

.slider-wrapper .slide-button.right {
    right: -25px;
}
        .slider-wrapper .image-list {
            display: flex;
            gap: 18px;
            font-size: 0;
            list-style: none;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .slider-wrapper .image-list .image-item {
    min-width: 200px; /* Adjust the width as per your preference */
    height: 300px; /* Adjust the height as per your preference */
    object-fit: cover;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
}

@media only screen and (max-width: 1023px) {
    .slider-wrapper .image-list .image-item {
        min-width: 150px; /* Adjust the width for mobile and tablets */
        height: 250px; /* Adjust the height for mobile and tablets */
    }
}
.slider-wrapper .image-list .image-item:hover {
    transform: scale(1.05);
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
    background-color: #f7f7f7;
}


        .container .slider-scrollbar {
            height: 24px;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .slider-scrollbar .scrollbar-track {
            background: #ccc;
            width: 100%;
            height: 2px;
            display: flex;
            align-items: center;
            border-radius: 4px;
            position: relative;
        }

        .slider-scrollbar:hover .scrollbar-track {
            height: 4px;
        }

        .slider-scrollbar .scrollbar-thumb {
            position: absolute;
            background: #000;
            top: 0;
            bottom: 0;
            width: 50%;
            height: 100%;
            cursor: grab;
            border-radius: inherit;
        }

        .slider-scrollbar .scrollbar-thumb:active {
            cursor: grabbing;
            height: 8px;
            top: -2px;
        }

        .slider-scrollbar .scrollbar-thumb::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: -10px;
            bottom: -10px;
        }

        /* Styles for mobile and tablets */
        @media only screen and (max-width: 1023px) {
            .slider-wrapper .slide-button {
                display: none !important;
            }

            .slider-wrapper .image-list {
                gap: 10px;
                margin-bottom: 15px;
            }

            .slider-scrollbar .scrollbar-thumb {
                width: 20%;
            }
        }
    </style>
        
<style>


.wrapper {
max-width: 1600px;
width: 100%;
position: relative;
}
.wrapper i {
    top: 50%;
    height: 50px;
    width: 50px;
    cursor: pointer;
    font-size: 1.25rem;
    position: absolute;
    text-align: center;
    line-height: 50px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.23);
    transform: translateY(-50%);
    transition: transform 0.1s linear;
    z-index: 1; /* Set the z-index to position the icons above the cards */
}

.wrapper i:first-child {
    left: -22px;
}

.wrapper i:last-child {
    right: -22px;
}
.wrapper .carousel{
display: grid;
grid-auto-flow: column;
grid-auto-columns: calc((100% / 7) - 12px);
overflow-x: auto;
scroll-snap-type: x mandatory;
gap: 16px;
border-radius: 8px;
scroll-behavior: smooth;
scrollbar-width: none;
}
.carousel::-webkit-scrollbar {
display: none;
}
.carousel.no-transition {
scroll-behavior: auto;
}
.carousel.dragging {
scroll-snap-type: none;
scroll-behavior: auto;
}
.carousel.dragging .card {
cursor: grab;
user-select: none;
}
.carousel :where(.card, .img) {
display: flex;
justify-content: center;
align-items: center;
}
.carousel .card {
    scroll-snap-align: start;
    height: 160px;
    list-style: none;
    background: white;
    cursor: pointer;
    padding-bottom: 15px;
    flex-direction: column;
    border-radius: 8px;
    border: 2px solid #e4e4e4; /* Add thickness with a border */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add depth with a box shadow */
    transition: transform 0.2s, box-shadow 0.2s; /* Add transition for smooth effects */

    /* Create an aura effect on hover and focus */
}

.carousel .card .img {
background: rgba(23, 24, 32, 0.95);
height: 65px;
width: 65px;
border-radius: 50%;
}
.card .img img {
width: 55px;
height: 55px;
border-radius: 50%;
object-fit: cover;
border: 4px solid #fff;
background-color: white;
}
.carousel .card h2 {
font-weight: 500;
font-size: 1.56rem;
margin: 30px 0 5px;
}
.carousel .card span {
color: #6A6D78;
font-size: 1.31rem;
}

@media screen and (max-width: 900px) {
.wrapper .carousel {
grid-auto-columns: calc((100% / 2) - 9px);
}
}

@media screen and (max-width: 600px) {
.wrapper .carousel {
grid-auto-columns: 100%;
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


<?php
// Initialize $row to an empty array to avoid undefined variable error
$row = [];

// Assuming you have established a database connection already (e.g., $conn)

// Get the teacher_id from the session
$teacher_id = $_SESSION['teacher_id'];

// Use prepared statements to fetch teacher information
$stmt = $conn->prepare("SELECT * FROM teacher WHERE teacher_id = ?");
$stmt->bind_param("s", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the teacher's data
    $row = $result->fetch_assoc();
} else {
    // Handle the case where the teacher's record is not found
    // You can set a default message or redirect to an error page here
}

$stmt->close();
?>
                        


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <?php
								$school_year_query = mysqli_query($conn,"select * from school_year order by school_year DESC")or die(mysqli_error());
								$school_year_query_row = mysqli_fetch_array($school_year_query);
								$school_year = $school_year_query_row['school_year'];
								?>

                <?php
                // Include the session code from session.php
                // Initialize $count to 0
                $count = 0;

                // Assuming you have established a database connection already (e.g., $conn)

                // Get the teacher_id from the session
                $teacher_id = $_SESSION['teacher_id'];

                // SQL query to fetch teacher class information
                $query = mysqli_query($conn, "SELECT * FROM teacher_class
                    LEFT JOIN class ON class.class_id = teacher_class.class_id
                    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                    WHERE teacher_id = '$teacher_id' AND school_year = '$school_year'") or die(mysqli_error());

                $count = mysqli_num_rows($query);
                ?>
                
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-end mb-4">
                    <div class="d-sm-flex align-items-center justify-content-end mb-4">
                    <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_bookModal">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add Book</button>
                </div>
                </div>

                <?php
include("dbcon.php");
$query = "SELECT * FROM category";
$result = mysqli_query($conn, $query);

// Create an array to store category names and images
$categories = [];

// Check if categories were retrieved successfully
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = [
            'name' => $row['category_name'],
            'image' => $row['image'],
            'id' => $row['category_id'],
        ];
    }
} else {
    echo 'Error fetching categories from the database.';
}

// Close the database connection if needed
?>


<!-- Content Row -->
<div class="row justify-content-center">
<div class="col-12 text-center mb-4">
            <h1 style = "color: black;" class="mb-3">Browse by Category</h1>
        </div>
    <div class="wrapper">
        <i id="left" class='fas fa-angle-left'></i>
        
        <ul class="carousel">
            <?php foreach ($categories as $category): ?>
                <a href="category.php?id=<?= $category['id'] ?>">
                <li class="card">
                    <div class="img mb-3">
                        <img src="<?php echo $category['image']; ?>" alt="img" draggable="false">
                    </div>
                        <h6 class="text-center"><?= htmlspecialchars($category['name']) ?></h6>
                </li>
                </a>
            <?php endforeach; ?>
        </ul>
   
        <i id="right" class='fas fa-angle-right'></i>
    </div>
</div>

<?php
// Establish a database connection (assuming you have already done this)

// Fetch all categories
$categoriesQuery = "SELECT * FROM category";
$categoriesResult = mysqli_query($conn, $categoriesQuery);

// Initialize a counter for generating unique IDs
$buttonCounter = 1;
$scrollbarCounter = 1;
// Check if there are any categories
if (mysqli_num_rows($categoriesResult) > 0) {
    while ($category = mysqli_fetch_assoc($categoriesResult)) {
        $category_id = $category['category_id'];
        $category_name = $category['category_name'];

        // Fetch books for the current category with book_status = 2
        $booksQuery = "SELECT * FROM booklist WHERE category_id = $category_id AND book_status = 'Available'";
        $booksResult = mysqli_query($conn, $booksQuery);

        // Check if there are any books in the current category
        if (mysqli_num_rows($booksResult) > 0) {
            // Display the category name and book slider
            echo '<div class="row">';
            echo '<div class="container mt-4">';
            echo '<h3 style="color: black;">' . $category_name . '</h3>';
            // Add the "See All" button with a link to the category page
            echo '<a href="category.php?id=' . $category_id . '" class="see-all-button">See All</a>';
            echo '<div class="slider-wrapper" data-category-id="' . $category_id . '">'; // Add a data attribute to identify the category
            echo '<button class="slide-button left" id="prev-slide-' . $buttonCounter . '" data-category-id="' . $category_id . '">';
            echo '<i id="left" class="fas fa-angle-left"></i>';
            echo '</button>';
            echo '<ul class="image-list" data-category-id="' . $category_id . '">';

            while ($book = mysqli_fetch_assoc($booksResult)) {
                $book_id = $book['book_id'];
                $bookCover = $book['book_cover'];

                // Display book covers and links to view_book.php using book_id
                echo '<a href="view_book.php?book_id=' . $book_id . '">';
                echo '<li>';
                echo '<img class="image-item" src="' . $bookCover . '" alt="img-' . $book_id . '" />';
                echo '</li>';
                echo '</a>';
            }

            echo '</ul>';
            echo '<button class="slide-button right" id="next-slide-' . $buttonCounter . '" data-category-id="' . $category_id . '">';
            echo '<i id="right" class="fas fa-angle-right"></i>';
            echo '</button>';
            echo '</div>';
            echo '<div class="slider-scrollbar" id="scrollbar-' . $scrollbarCounter . '">';
            echo '<div class="scrollbar-track">';
            echo '<div class="scrollbar-thumb"></div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
            $buttonCounter++; // Increment the counter for the next category
            $scrollbarCounter++; // Increment the scrollbar counter for the next category
        }
    }
}
?>


         


        
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
                                                        <label for="book_cover" class="form-label">Book Cover Photo:</label>
                                                        <input type="file" class="form-control" name="book_cover" id="book_cover" accept="image/*">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="file_path" class="form-label">E-book File (PDF only):</label>
                                                        <input type="file" class="form-control" name="file_path" id="file_path" accept="application/pdf">
                                                    </div>


                                                </div>
                                                
                                               

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_book" class="btn btn-success">Submit book for Approval</button>
                                                </div>
                                            </form>
                                    </div> <!--modal content -->
                                </div> <!--modal dialog -->
                    </div>  <!--modal fade -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>



