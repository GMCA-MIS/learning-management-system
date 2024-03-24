<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>


<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>

<!-- Data Table scripts -->
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js"></script> 

<!-- Flatpickr -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
   CKEDITOR.replace( 'editor1' );
</script>

<!--JS for displaying data from EDIT pop up modal "Manage Departments" -->
<script>
    $(document).ready(function () {

        $('.edit_btn').on('click', function () {

            $('#editManageDepartments').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#edit_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore
            $('#edit_Department_Name').val(data[1]);
            $('#edit_dean').val(data[2]);

        });
    });
</script>

<!--JS for Warning Deleting data from DELETE pop up modal "Manage Books" -->
<script>
    $(document).ready(function () {

        $('.delete_btn').on('click', function () {

            $('#delete_bookModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#delete_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    });

    
</script>

<!--JS for Warning Deleting data from Archive pop up modal "Manage Books" -->
<script>
    $(document).ready(function () {

        $('.archive_btn').on('click', function () {

            $('#archive_bookModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#archive_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    });

    
</script>

</script>

<!--JS for Warning Deleting data from Restore pop up modal "Manage Books" -->
<script>
    $(document).ready(function () {

        $('.restore_btn').on('click', function () {

            $('#restore_bookModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#restore_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    });

    
</script>
<!--JS for Warning Deleting data from DELETE pop up modal "Manage Department" -->
<script>
    $(document).ready(function () {

        $('.delete_btn').on('click', function () {

            $('#deleteDepartment').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#delete_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    });

    
</script>



<!--JS for displaying data from EDIT pop up modal"Manage INSTRUCTORS" -->
<script>
    $(document).ready(function () {

        $('.edit_btn').on('click', function () {

            $('#editinstructorsmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#edit_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore
            $('#edit_firstname').val(data[1]);
            $('#edit_lastname').val(data[2]);
            $('#edit_email').val(data[4]);
            $('#edit_specialization').val(data[9]);
        });
    });

    
</script>




<!--JS for Warning Deleting data from DELETE pop up modal "Manage INSTRUCTORS" -->
<script>
    $(document).ready(function () {

        $('.delete_btn').on('click', function () {

            $('#delete_instructors').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#delete_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    });

    
</script>

<!--JS for displaying data from EDIT pop up modal"Manage CLASS" -->
<script>
 $(document).ready(function () {
    $('.edit_btn').on('click', function () {
        $('#edit_categoryModal').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function () {
            return $(this).text().trim(); // Trim the text to remove leading/trailing spaces
        }).get();

        console.log(data);

        $('#edit_ID').val(data[1]);
        $('#edit_Class_Name').val(data[2]);
    });
});


    
</script>

<!--JS for Warning Deleting data from DELETE pop up modal "Manage CLASS" -->
<script>
    $(document).ready(function () {

        $('.delete_btn').on('click', function () {

            $('#delete_categoryModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#delete_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    });

    
</script>

<!--JS for displaying data from EDIT pop up modal"Manage STUDENTS" -->
<script>
    $(document).ready(function () {

        $('.edit_btn').on('click', function () {

            $('#edit_studentModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#edit_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore
            $('#edit_class_id').val(data[6]);
            $('#edit_lrn').val(data[2]);
            $('#edit_firstname').val(data[4]);
            $('#edit_lastname').val(data[5]);
            $('#edit_email').val(data[7]);
            $('#edit_dob').val(data[8]);
          
           
        });
    });

    
</script>


<!--JS for Warning Deleting data from DELETE pop up modal "Manage STUDENTS" -->
<script>
    $(document).ready(function () {

        $('.delete_btn').on('click', function () {

            $('#deletestudentModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#delete_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    });

    
</script>


<!--JS for displaying data from EDIT pop up modal"Manage COURSES" -->
<script>
    $(document).ready(function () {

        $('.edit_btn').on('click', function () {

            $('#edit_courseModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#edit_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore
            $('#edit_course_code').val(data[1]);
            $('#edit_course_title').val(data[2]);
        
          
           
        });
    });

    
</script>


<!--JS for Warning Deleting data from DELETE pop up modal "Manage COURSES" -->
<script>
    $(document).ready(function () {

        $('.delete_btn').on('click', function () {

            $('#delete_courseModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#delete_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    }); 
</script>

<!--JS for displaying data from EDIT pop up modal"Manage ASSIGNED COURSES" -->
<script>
    $(document).ready(function () {

        $('.edit_btn').on('click', function () {

            $('#edit_assigncourseModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#edit_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore
            $('#edit_subject_id').val(data[1]);
            $('#edit_class_id').val(data[2]);
            $('#edit_teacher_id').val(data[4]);
            
        });
    });

    
</script>

<!--JS for Warning Deleting data from DELETE pop up modal "ASSIGNED COURSES" -->
<script>
    $(document).ready(function () {

        $('.delete_btn').on('click', function () {

            $('#deny_bookApproval').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#delete_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    }); 
</script>

<!--JS for Warning Deleting data from DELETE pop up modal "ASSIGNED COURSES" -->
<script>
    $(document).ready(function () {

        $('.delete_btn').on('click', function () {

            $('#delete_assigncourse').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#delete_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    }); 
</script>


<!--JS for displaying data from EDIT pop up modal"SCHOOL YEAR" -->
<script>
    $(document).ready(function () {

        $('.edit_btn').on('click', function () {

            $('#editSchoolYearModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#edit_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore
            $('#edit_school_year').val(data[1]);
            $('#edit_start_date').val(data[2]);
            $('#edit_end_date').val(data[3]);

        });
    });

    
</script>


<!--JS for Warning Deleting data from DELETE pop up modal "SCHOOL YEAR" -->
<script>
    $(document).ready(function () {

        $('.delete_btn').on('click', function () {

            $('#delete_schoolyearModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#delete_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore


        });
    }); 
</script>






<!--Data Tales/Pagination and Search -->
<script>
$(document).ready(function () {
    $('#dataTableID').DataTable();
});
</script>


<script>
    function formatStudentNumber(input) {
    // Remove all non-digit characters from the input
    var value = input.value.replace(/\D/g, '');

    // Insert a dash after the fourth character if the value is longer than 4 characters
    if (value.length > 6) {
        value = value.slice(0, 6) + '-' + value.slice(6);
    }

    // Set the formatted value back into the input field
    input.value = value;
}

</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.6/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.6/dist/flatpickr.min.js"></script>

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
		<script>
		CKEDITOR.replace( 'description' );
		</script>

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    function initializeCKEditor(elementId) {
        CKEDITOR.replace(elementId);
    }
</script>

<!--JS for displaying data from EDIT pop up modal"Manage CLASS" -->
<script>
$(document).ready(function () {
    $('.edit_btn').on('click', function () {
        $('#edit_bookModal').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function () {
            return $(this).text().trim();
        }).get();

        console.log(data);

        $('#edit_book_id').val(data[0]);
        $('#edit_title').val(data[2]);
        $('#edit_description').val(data[3]);
        $('#edit_author').val(data[4]);
        $('#edit_call_number').val(data[8]);
        $('#edit_category').val(data[6]);
        $('#edit_publication_year').val(data[5]); // Update index for publication year
        $('#edit_book_status').val(data[7]); // Update index for book status
        
        console.log($('#edit_book_id').val()); // Log the value of edit_book_id
    });
});
</script>



<script>
$(document).ready(function () {
    // Your existing code...

    // Initialize Flatpickr for the date input field
    flatpickr(".flatpickr", {
        dateFormat: "Y-m-d", // You can customize the date format
    });
});

</script>

<!-- For CALENDAR start and end dates -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Flatpickr on the date input element
        const startDateInput = document.getElementById("start_date");
        const endDateInput = document.getElementById("end_date");

        const config = {
            dateFormat: "Y-m-d", // Set the desired date format
        };

        // Set the minimum date for the end_date based on the start_date
        startDateInput.addEventListener("change", function() {
            config.minDate = startDateInput.value;
            flatpickr(endDateInput, config);
        });

        flatpickr(startDateInput, config);
        flatpickr(endDateInput, config);
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Flatpickr on the date input element
        const startDateInput = document.getElementById("edit_start_date");
        const endDateInput = document.getElementById("edit_end_date");

        const config = {
            dateFormat: "Y-m-d", // Set the desired date format
        };

        // Set the minimum date for the end_date based on the start_date
        startDateInput.addEventListener("change", function() {
            config.minDate = startDateInput.value;
            flatpickr(endDateInput, config);
        });

        flatpickr(startDateInput, config);
        flatpickr(endDateInput, config);
    });
</script>


<script>
    //Library slider
const initSlider = () => {
    const imageList = document.querySelector(".slider-wrapper .image-list");
    const slideButtons = document.querySelectorAll(".slider-wrapper .slide-button");
    const sliderScrollbar = document.querySelector(".container .slider-scrollbar");
    const scrollbarThumb = sliderScrollbar.querySelector(".scrollbar-thumb");
    const maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;
    
    // Handle scrollbar thumb drag
    scrollbarThumb.addEventListener("mousedown", (e) => {
        const startX = e.clientX;
        const thumbPosition = scrollbarThumb.offsetLeft;
        const maxThumbPosition = sliderScrollbar.getBoundingClientRect().width - scrollbarThumb.offsetWidth;
        
        // Update thumb position on mouse move
        const handleMouseMove = (e) => {
            const deltaX = e.clientX - startX;
            const newThumbPosition = thumbPosition + deltaX;
            // Ensure the scrollbar thumb stays within bounds
            const boundedPosition = Math.max(0, Math.min(maxThumbPosition, newThumbPosition));
            const scrollPosition = (boundedPosition / maxThumbPosition) * maxScrollLeft;
            
            scrollbarThumb.style.left = `${boundedPosition}px`;
            imageList.scrollLeft = scrollPosition;
        }
        // Remove event listeners on mouse up
        const handleMouseUp = () => {
            document.removeEventListener("mousemove", handleMouseMove);
            document.removeEventListener("mouseup", handleMouseUp);
        }
        // Add event listeners for drag interaction
        document.addEventListener("mousemove", handleMouseMove);
        document.addEventListener("mouseup", handleMouseUp);
    });
// Slide images according to the slide button clicks with looping
slideButtons.forEach(button => {
    button.addEventListener("click", () => {
        const buttonId = button.id; // Get the ID of the clicked button
        const categoryId = button.getAttribute('data-category-id'); // Get the data-category-id attribute

        // Get the image-list and slider-scrollbar elements for the current category
        const imageList = document.querySelector(`.slider-wrapper[data-category-id="${categoryId}"] .image-list`);
        const maxScrollLeft = imageList.scrollWidth - imageList.clientWidth;
        
        let direction = buttonId.startsWith(`prev-slide-${categoryId}`) ? -1 : 1;
        let scrollAmount = 180 * direction; // Adjust this value based on your new image dimensions

        // Calculate the new scroll position
        let newScrollPosition = imageList.scrollLeft + scrollAmount;

        // Check if the user is at the beginning or end
        if (newScrollPosition < 0) {
            // If at the beginning, loop to the end
            newScrollPosition = maxScrollLeft;
        } else if (newScrollPosition > maxScrollLeft) {
            // If at the end, loop to the beginning
            newScrollPosition = 0;
        }

        // Scroll to the new position
        imageList.scrollTo({ left: newScrollPosition, behavior: "smooth" });
    });
});

     // Show or hide slide buttons based on scroll position
    const handleSlideButtons = () => {
        slideButtons[0].style.display = imageList.scrollLeft <= 0 ? "none" : "flex";
        slideButtons[1].style.display = imageList.scrollLeft >= maxScrollLeft ? "none" : "flex";
    }
    // Update scrollbar thumb position based on image scroll
    const updateScrollThumbPosition = () => {
        const scrollPosition = imageList.scrollLeft;
        const thumbPosition = (scrollPosition / maxScrollLeft) * (sliderScrollbar.clientWidth - scrollbarThumb.offsetWidth);
        scrollbarThumb.style.left = `${thumbPosition}px`;
    }

       // Function to automatically move to the next slide
       const autoScroll = () => {
        // Calculate the new scroll position for the next slide
        let newScrollPosition = imageList.scrollLeft + imageList.clientWidth;

        // Check if the user is at the end
        if (newScrollPosition > maxScrollLeft) {
            // If at the end, loop to the beginning
            newScrollPosition = 0;
        }

        // Scroll to the new position
        imageList.scrollTo({ left: newScrollPosition, behavior: "smooth" });
    };

    // Set the time interval for automatic scrolling (e.g., every 3 seconds)
    const scrollInterval = 10000; // 3 seconds in milliseconds

    // Start the automatic scrolling
    const autoScrollInterval = setInterval(autoScroll, scrollInterval);

    // Function to stop auto-scrolling when the user interacts with the slider
    const stopAutoScroll = () => {
        clearInterval(autoScrollInterval);
    };

    // Call this function when the user interacts with the slider (e.g., mousedown)
    imageList.addEventListener("mousedown", stopAutoScroll);

    // Call these two functions when image list scrolls
    imageList.addEventListener("scroll", () => {
        updateScrollThumbPosition();
        handleSlideButtons();
    });
}
window.addEventListener("resize", initSlider);
window.addEventListener("load", initSlider);

</script>


<script>
    //Library Categories
        const wrapper = document.querySelector(".wrapper");
const carousel = document.querySelector(".carousel");
const firstCardWidth = carousel.querySelector(".card").offsetWidth;
const arrowBtns = document.querySelectorAll(".wrapper i");
const carouselChildrens = [...carousel.children];

let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;

// Get the number of cards that can fit in the carousel at once
let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);

// Insert copies of the last few cards to beginning of carousel for infinite scrolling
carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
    carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
});

// Insert copies of the first few cards to end of carousel for infinite scrolling
carouselChildrens.slice(0, cardPerView).forEach(card => {
    carousel.insertAdjacentHTML("beforeend", card.outerHTML);
});

// Scroll the carousel at appropriate postition to hide first few duplicate cards on Firefox
carousel.classList.add("no-transition");
carousel.scrollLeft = carousel.offsetWidth;
carousel.classList.remove("no-transition");

// Add event listeners for the arrow buttons to scroll the carousel left and right
arrowBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
    });
});

const dragStart = (e) => {
    isDragging = true;
    carousel.classList.add("dragging");
    // Records the initial cursor and scroll position of the carousel
    startX = e.pageX;
    startScrollLeft = carousel.scrollLeft;
}

const dragging = (e) => {
    if(!isDragging) return; // if isDragging is false return from here
    // Updates the scroll position of the carousel based on the cursor movement
    carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
}

const dragStop = () => {
    isDragging = false;
    carousel.classList.remove("dragging");
}

const infiniteScroll = () => {
    // If the carousel is at the beginning, scroll to the end
    if(carousel.scrollLeft === 0) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
        carousel.classList.remove("no-transition");
    }
    // If the carousel is at the end, scroll to the beginning
    else if(Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.offsetWidth;
        carousel.classList.remove("no-transition");
    }

    // Clear existing timeout & start autoplay if mouse is not hovering over carousel
    clearTimeout(timeoutId);
    if(!wrapper.matches(":hover")) autoPlay();
}

const autoPlay = () => {
    if(window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
    // Autoplay the carousel after every 2500 ms
    timeoutId = setTimeout(() => carousel.scrollLeft += firstCardWidth, 2500);
}
autoPlay();

carousel.addEventListener("mousedown", dragStart);
carousel.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);
carousel.addEventListener("scroll", infiniteScroll);
wrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
wrapper.addEventListener("mouseleave", autoPlay);
        </script>