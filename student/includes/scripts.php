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

<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
   CKEDITOR.replace( 'description1' );
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

            $('#edit_classModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            //ID attribute ang kinukuha
            $('#edit_ID').val(data[0]); //Hindi sya galing sa database pero lahat ng attributes sa database dito maiistore
            $('#edit_Class_Name').val(data[1]);
           
        });
    });

    
</script>

<!--JS for Warning Deleting data from DELETE pop up modal "Manage CLASS" -->
<script>
    $(document).ready(function () {

        $('.delete_btn').on('click', function () {

            $('#delete_class').modal('show');

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


<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
		<script>
		CKEDITOR.replace( 'objectives' );
		</script>


<script>
$(document).ready(function () {
    // Your existing code...

    // Initialize Flatpickr for the date input field
    flatpickr(".flatpickr", {
            enableTime: true, // Enable time picker
            noCalendar: false, // Show calendar
            dateFormat: "Y-m-d H:i", // Date and time format
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
const search = document.querySelector('.input-group input'),
    table_rows = document.querySelectorAll('tbody tr'),
    table_headings = document.querySelectorAll('thead th');

// 1. Searching for specific data of HTML table
search.addEventListener('input', searchTable);

function searchTable() {
    table_rows.forEach((row, i) => {
        let table_data = row.textContent.toLowerCase(),
            search_data = search.value.toLowerCase();

        row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
        row.style.setProperty('--delay', i / 25 + 's');
    })

    document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
        visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
    });
}

// 2. Sorting | Ordering data of HTML table

table_headings.forEach((head, i) => {
    let sort_asc = true;
    head.onclick = () => {
        table_headings.forEach(head => head.classList.remove('active'));
        head.classList.add('active');

        document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
        table_rows.forEach(row => {
            row.querySelectorAll('td')[i].classList.add('active');
        })

        head.classList.toggle('asc', sort_asc);
        sort_asc = head.classList.contains('asc') ? false : true;

        sortTable(i, sort_asc);
    }
})


function sortTable(column, sort_asc) {
    [...table_rows].sort((a, b) => {
        let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
            second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

        return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
    })
        .map(sorted_row => document.querySelector('tbody').appendChild(sorted_row));
}

// 3. Converting HTML table to PDF

const pdf_btn = document.querySelector('#toPDF');
const customers_table = document.querySelector('#customers_table');

const toPDF = function (customers_table) {
    const html_code = `
    <link rel="stylesheet" href="style.css">
    <main class="table" >${customers_table.innerHTML}</main>
    `;

    const new_window = window.open();
    new_window.document.write(html_code);

    setTimeout(() => {
        new_window.print();
        new_window.close();
    }, 400);
}

pdf_btn.onclick = () => {
    toPDF(customers_table);
}

// 4. Converting HTML table to JSON

const json_btn = document.querySelector('#toJSON');

const toJSON = function (table) {
    let table_data = [],
        t_head = [],

        t_headings = table.querySelectorAll('th'),
        t_rows = table.querySelectorAll('tbody tr');

    for (let t_heading of t_headings) {
        let actual_head = t_heading.textContent.trim().split(' ');

        t_head.push(actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase());
    }

    t_rows.forEach(row => {
        const row_object = {},
            t_cells = row.querySelectorAll('td');

        t_cells.forEach((t_cell, cell_index) => {
            const img = t_cell.querySelector('img');
            if (img) {
                row_object['customer image'] = decodeURIComponent(img.src);
            }
            row_object[t_head[cell_index]] = t_cell.textContent.trim();
        })
        table_data.push(row_object);
    })

    return JSON.stringify(table_data, null, 4);
}

json_btn.onclick = () => {
    const json = toJSON(customers_table);
    downloadFile(json, 'json')
}

// 5. Converting HTML table to CSV File

const csv_btn = document.querySelector('#toCSV');

const toCSV = function (table) {
    // Code For SIMPLE TABLE
    // const t_rows = table.querySelectorAll('tr');
    // return [...t_rows].map(row => {
    //     const cells = row.querySelectorAll('th, td');
    //     return [...cells].map(cell => cell.textContent.trim()).join(',');
    // }).join('\n');

    const t_heads = table.querySelectorAll('th'),
        tbody_rows = table.querySelectorAll('tbody tr');

    const headings = [...t_heads].map(head => {
        let actual_head = head.textContent.trim().split(' ');
        return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
    }).join(',') + ',' + 'image name';

    const table_data = [...tbody_rows].map(row => {
        const cells = row.querySelectorAll('td'),
            img = decodeURIComponent(row.querySelector('img').src),
            data_without_img = [...cells].map(cell => cell.textContent.replace(/,/g, ".").trim()).join(',');

        return data_without_img + ',' + img;
    }).join('\n');

    return headings + '\n' + table_data;
}

csv_btn.onclick = () => {
    const csv = toCSV(customers_table);
    downloadFile(csv, 'csv', 'customer orders');
}

// 6. Converting HTML table to EXCEL File

const excel_btn = document.querySelector('#toEXCEL');

const toExcel = function (table) {
    // Code For SIMPLE TABLE
    // const t_rows = table.querySelectorAll('tr');
    // return [...t_rows].map(row => {
    //     const cells = row.querySelectorAll('th, td');
    //     return [...cells].map(cell => cell.textContent.trim()).join('\t');
    // }).join('\n');

    const t_heads = table.querySelectorAll('th'),
        tbody_rows = table.querySelectorAll('tbody tr');

    const headings = [...t_heads].map(head => {
        let actual_head = head.textContent.trim().split(' ');
        return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
    }).join('\t') + '\t' + 'image name';

    const table_data = [...tbody_rows].map(row => {
        const cells = row.querySelectorAll('td'),
            img = decodeURIComponent(row.querySelector('img').src),
            data_without_img = [...cells].map(cell => cell.textContent.trim()).join('\t');

        return data_without_img + '\t' + img;
    }).join('\n');

    return headings + '\n' + table_data;
}

excel_btn.onclick = () => {
    const excel = toExcel(customers_table);
    downloadFile(excel, 'excel');
}

const downloadFile = function (data, fileType, fileName = '') {
    const a = document.createElement('a');
    a.download = fileName;
    const mime_types = {
        'json': 'application/json',
        'csv': 'text/csv',
        'excel': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    }
    a.href = `
        data:${mime_types[fileType]};charset=utf-8,${encodeURIComponent(data)}
    `;
    document.body.appendChild(a);
    a.click();
    a.remove();
}

</script>



<script>
    // File Viewer PDF
    document.addEventListener("DOMContentLoaded", function () {
        const pdfLinks = document.querySelectorAll(".pdf-link");
        const pdfViewer = document.getElementById("pdfViewer");
        const closeBtn = document.getElementById("closePdfViewer");

        pdfLinks.forEach(function (link) {
            link.addEventListener("click", function (event) {
                event.preventDefault(); // Prevent the default behavior of clicking a link

                const pdfUrl = link.getAttribute("href");

                // Set the PDF URL as the source of the iframe and display it
                pdfViewer.setAttribute("src", pdfUrl);
                pdfViewer.style.display = "block";

                // Show the close button
                closeBtn.style.display = "block";
            });
        });

        // Add a click event listener to the close button
        closeBtn.addEventListener("click", function () {
            // Hide the iframe and close button
            pdfViewer.style.display = "none";
            closeBtn.style.display = "none";
        });
    });
</script>

<script>

//For upload create tab pane
$(document).ready(function() {
    $('#assignmentTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // Handle tab selection, if needed
    });
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



<script>
    
  // Add a click event listener to the submit button
  document.getElementById("submit_button_quiz").addEventListener("click", function() {
    // Display a SweetAlert confirmation dialog
    Swal.fire({
      title: 'Confirm Submission',
      text: 'Are you sure you want to submit the quiz?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, submit it!',
      cancelButtonText: 'No, cancel',
    }).then((result) => {
      // If the user clicks "Yes, submit it!", trigger the form submission
      if (result.isConfirmed) {
        // Create a hidden input field for 'submit_quiz' and set it to 'submit_quiz'
        var hiddenInput = document.createElement("input");
        hiddenInput.setAttribute("type", "hidden");
        hiddenInput.setAttribute("name", "submit_quiz");
        hiddenInput.setAttribute("value", "submit_quiz");
        
        // Append the hidden input to the form
        document.getElementById("quiz-form").appendChild(hiddenInput);
        
        // Submit the form
        document.getElementById("quiz-form").submit();
      }
    });
  });

</script>


<script>
    
  // Add a click event listener to the submit button
  document.getElementById("submit_button").addEventListener("click", function() {
    // Display a SweetAlert confirmation dialog
    Swal.fire({
      title: 'Confirm Submission',
      text: 'Are you sure you want to submit the exam?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, submit it!',
      cancelButtonText: 'No, cancel',
    }).then((result) => {
      // If the user clicks "Yes, submit it!", trigger the form submission
      if (result.isConfirmed) {
        // Create a hidden input field for 'submit_exam' and set it to 'submit_exam'
        var hiddenInput = document.createElement("input");
        hiddenInput.setAttribute("type", "hidden");
        hiddenInput.setAttribute("name", "submit_exam");
        hiddenInput.setAttribute("value", "submit_exam");
        
        // Append the hidden input to the form
        document.getElementById("exam-form").appendChild(hiddenInput);
        
        // Submit the form
        document.getElementById("exam-form").submit();
      }
    });
  });

</script>


<script>
    var currentPage = 1;
    var totalPages = <?php echo $totalPages; ?>;

    function showPrevPage() {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    }

    function showNextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    }

    function showPage(page) {
        var questionPages = document.querySelectorAll('.question-page');
        questionPages.forEach(function (pageElement) {
            pageElement.style.display = 'none';
        });

        var currentPageElement = document.querySelector('.question-page[data-page="' + page + '"]');
        if (currentPageElement) {
            currentPageElement.style.display = 'block';
        }
    }
</script>


<!-- JavaScript for Step-by-Step Display -->
<script>
    var currentQuestion = 1;
    var questionContainers = document.querySelectorAll(".question-container");
    var questionNumbers = document.querySelectorAll(".btns"); // Update the class name here
    var submitButton = document.getElementById("submit_button_quiz"); // Assuming your submit button has the id "submit_button"
    var nextButton = document.getElementById("next-button"); // Assuming your "Next" button has the id "next-button"

    function showQuestion(questionId) {
        questionContainers.forEach((container, index) => {
            if (index + 1 === questionId) {
                container.style.display = "block";
            } else {
                container.style.display = "none";
            }
        });
    }

    // Add click event listeners to question numbers
    questionNumbers.forEach((number) => {
        number.addEventListener("click", () => {
            const questionId = parseInt(number.getAttribute("data-question-id"), 10);
            showQuestion(questionId);
            currentQuestion = questionId;

            // Toggle the "clicked" class for styling
            questionNumbers.forEach((btn) => {
                btn.classList.remove("clicked");
            });
            number.classList.add("clicked");

            // Adjust the display of "Next" and "Submit" buttons
            if (currentQuestion === questionContainers.length) {
                nextButton.style.display = "none";
                submitButton.style.display = "inline";
            } else {
                nextButton.style.display = "inline";
                submitButton.style.display = "none";
            }
        });
    });

    // Initially hide all questions except the first one
    questionContainers.forEach((container, index) => {
        if (index !== 0) {
            container.style.display = "none";
        }
    });

    // Function to show the next question
    function showNextQuestion() {
        if (currentQuestion < questionContainers.length) {
            showQuestion(currentQuestion + 1);
            currentQuestion++;
            questionNumbers.forEach((btn) => {
                btn.classList.remove("clicked");
            });
            questionNumbers[currentQuestion - 1].classList.add("clicked");

            // Adjust the display of "Next" and "Submit" buttons
            if (currentQuestion === questionContainers.length) {
                nextButton.style.display = "none";
                submitButton.style.display = "inline";
            } else {
                nextButton.style.display = "inline";
                submitButton.style.display = "none";
            }
        }
    }

    // Function to show the previous question
    function showPrevQuestion() {
        if (currentQuestion > 1) {
            showQuestion(currentQuestion - 1);
            currentQuestion--;
            questionNumbers.forEach((btn) => {
                btn.classList.remove("clicked");
            });
            questionNumbers[currentQuestion - 1].classList.add("clicked");

            // Adjust the display of "Next" and "Submit" buttons
            nextButton.style.display = "inline";
            submitButton.style.display = "none";
        }
    }
    
    // Initially hide the submit button
    submitButton.style.display = "none";
</script>

<script>
    function startQuizTimer(quizTime) {
        var countdownElement = document.getElementById("countdown");
        var formElement = document.getElementById("quiz-form"); // Ensure this matches your form ID
        var submitButton = document.getElementById("quiz_submit");

        function updateTimer(timeRemaining) {
            var minutes = Math.floor((timeRemaining / 1000 / 60) % 60);
            var seconds = Math.floor((timeRemaining / 1000) % 60);

            countdownElement.textContent = minutes + "m " + seconds + "s";

            if (timeRemaining <= 0) {
                countdownElement.textContent = "Time's up!";
                formElement.submit(); // Use form submission instead of button click
                sessionStorage.removeItem("quizStartTime");
                return;
            }
        }

        var startTime = sessionStorage.getItem("quizStartTime");

        if (!startTime) {
            startTime = new Date().getTime();
            sessionStorage.setItem("quizStartTime", startTime);
        }

        var currentTime = new Date().getTime();
        var elapsedTime = currentTime - startTime;
        var timeRemaining = quizTime * 1000 - elapsedTime;

        if (timeRemaining <= 0) {
            countdownElement.textContent = "Time's up!";
            formElement.submit();
            sessionStorage.removeItem("quizStartTime");
            return;
        }

        updateTimer(timeRemaining);

        var timerInterval = setInterval(function () {
            var currentTime = new Date().getTime();
            var elapsedTime = currentTime - startTime;
            var timeRemaining = quizTime * 1000 - elapsedTime;

            updateTimer(timeRemaining);

            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
            }
        }, 1000);

        // Add event listener for form submission
        formElement.addEventListener("submit", function (event) {
            // Additional actions before or after form submission can be added here if needed.
            sessionStorage.removeItem("quizStartTime");
        });
    }

    var quizTime = <?php echo json_encode($quiz_time); ?>;

    window.onload = function () {
        window.document.body.onload = doThis(); // note removed parentheses
    };

    function doThis() {
        if (document.getElementById("countdown")) {
            quizTime = <?php echo json_encode($quiz_time); ?>;
            startQuizTimer(quizTime);
        } else {
        }
    }

    
</script> 
