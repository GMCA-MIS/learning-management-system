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
   CKEDITOR.replace( 'description12' );
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
            $('#edit_department_name').val(data[6]);
            $('#edit_firstname').val(data[1]);
            $('#edit_lastname').val(data[2]);
            $('#edit_email').val(data[3]);
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

        $('#edit_ID').val(data[0]);
        $('#edit_Class_Name').val(data[1]);

        // Set the value of the select based on data[2]
        $('#edit_strand').val(data[2]); // Assuming data[2] contains the correct value for the strand
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
            $('#edit_firstname').val(data[4]);
            $('#edit_lrn').val(data[2]);
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
            $('#edit_course_type').val(data[3]);
            $('#edit_track').val(data[4]);
            $('#edit_description').val(data[5]);
        
          
           
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

<!--JS for displaying data from EDIT pop up modal "Manage Coordinators" -->
<script>
$(document).ready(function () {
    $('.edit_btn').on('click', function () {
        $('#editManageCoordinators').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function () {
            return $(this).text().trim();
        }).get();

        console.log(data);

        // ID attribute ang kinukuha
        $('#edit_ID').val(data[0]);
        $('#edit_firstname').val(data[1]);
        $('#edit_lastname').val(data[2]);
        $('#edit_email').val(data[3]);

        // Assuming user_type is the last element in the array, adjust this if needed
        var user_type = data[data.length - 1];
        $('#edit_user_type').val(user_type);
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
        		<script>
		CKEDITOR.replace( 'description13' );
		</script>

</script>
        		<script>
		CKEDITOR.replace( 'description1' );
		</script>
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    function initializeCKEditor(elementId) {
        CKEDITOR.replace(elementId);
    }
</script>


<script>
$(document).ready(function () {
    // Your existing code...

    // Initialize Flatpickr for the date input field
    flatpickr(".flatpickr", {
            dateFormat: "Y-m-d H:i", // Date and time format
        });
    });
</script>
<script>
$(document).ready(function () {
    // Your existing code...

    // Initialize Flatpickr for the date input field
    flatpickr(".flatpickr1", {
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

<!-- Include CKEditor script -->
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>



<!-- Initialize CKEditor -->
<script>
    // Wait for the document to be fully loaded before initializing CKEditor
    document.addEventListener('DOMContentLoaded', function () {
        // Get all elements with the 'description-textarea' class
        var textareas = document.querySelectorAll('.description-textarea');

        // Loop through each textarea element and replace it with CKEditor instance
        textareas.forEach(function (textarea) {
            CKEDITOR.replace(textarea);
        });
    });
</script>

