<?php
include('teacher_session.php'); ?>
<?php $get_id = $_GET['id']; ?>
<?php
include('includes/topbar.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
include('dbcon.php');
include('initialize.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo '../css1/bootstrap.min.css?' . time(); ?>">
    <link rel="stylesheet" href="<?php echo '../fullcalendar/lib/main.min.css?' . time(); ?>">
    <script src="<?php echo '../js1/jquery-3.6.0.min.js?' . time(); ?>"></script>
    <script src="<?php echo '../js1/bootstrap.min.js?' . time(); ?>"></script>
    <script src="<?php echo '../fullcalendar/lib/main.min.js?' . time(); ?>"></script>
    <link rel="stylesheet" href="<?php echo 'css1/style.css?' . time(); ?>">
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/js/bootstrap.min.js"></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    <script type='text/javascript'
        src='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js'></script>
    <style>
        <style>@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            list-style: none;
        }

        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            font-family: Apple Chancery, cursive;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }

        table,
        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }

        /* ---------------- CALENDAR---------------------- */
        .fixed-calendar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow-y: auto;
            height: 100%;
            z-index: 1;
        }

        /* COLOR NG SHADES SA LOOB NG CALENDAR/SHADE NG MGA EVENTS*/
        .fc-event-main {
            background-color: #333;
            color: #f0f0f0;
        }

        #calendar .fc-event-time {
        display: none;
        }
        /* ---------------- SCHEDULE FORM---------------------- */

        /* FOOTER NG SCHEDULE FORM */
        .card-footer {
            background-color: white;
            /* Set white background for the card-footer */
            padding: 10px;
            /* Add some padding to the card-footer, adjust as needed */
        }

        /* ---------------- EVENT LIST---------------------- */
        /* CONTAINER MISMO NG EVENT LIST */
        .events-wrapper {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            max-width: 400px;
            max-height: 500px;
            overflow-y: auto;
        }

        /* CONTAINER SA LOOB NG EVENT LIST */
        .event-container {
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 1px;
            background-color: #f8f9fa;
            max-width: 500px;
            display: flex;
            justify-content: space-between;
            /* Add this line */
        }

        /* MGA FONTS EVENT LIST */
        .event-container {
            font-size: 13px;
        }

        /* EDIT AND DELETE NG EVENT LIST */
        .event-actions {
            width: 30%;
            display: flex;
        }

        .event-actions button {
            width: 25px;
            height: 25px;
            font-size: 14px;
            margin-right: 5px;
            background-color: #001f3f;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .event-actions button:hover {
            background-color: #003366;
        }
    </style>
</head>

<body>

	 <!-- breadcrumb -->
     <?php
$class_query = mysqli_query($conn, "SELECT * FROM teacher_class
LEFT JOIN class ON class.class_id = teacher_class.class_id
LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
WHERE teacher_class_id = '$get_id' AND teacher_id = '$teacher_id'") or die(mysqli_error());

// Check if any rows are returned
if (mysqli_num_rows($class_query) == 0) {
// Redirect to deny.php
echo '<script>window.location.href = "../deny.php";</script>';
exit(); // Make sure to exit after the header redirection
} ?>
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
                <div class="d-sm-flex align-items-center justify-content-between mb-4"
                    style="margin-top: 27px; margin-left: 10px;">
                    <h3 class="h4 mb-0 text-gray-800">
                        <!-- Your page heading content here -->
                    </h3>
                </div>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Your topbar content here -->
                </ul>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Your body content here -->


                <!-- Your other body content here -->
            </div>

            <!-- End of Page Content -->

            <div class="container py-5" id="page-container">
                <div class="row">
                    <div class="col-md-8">
                        <div id="calendar"></div>
                    </div>

                    <div class="col-md-4">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary mb-3" id="toggleFormBtn" data-bs-toggle="modal"
                                data-bs-target="#scheduleForm">
                                Add Event
                            </button>
                        </div>



                        <!-- Form -->

                        <!-- Form -->
                        <div class="modal fade" id="scheduleForm" tabindex="-1" aria-labelledby="scheduleFormLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="scheduleFormLabel">Add Schedule</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="background-color: white;">
                                        <form action="save_schedule.php" method="post" id="schedule-form">
                                            <input type="hidden" name="id" value="">
                                            <input type="hidden" name="get_id" value="<?php echo $get_id ?>">
                                            <div class="mb-2">
                                                <label for="title" class="control-label">Title</label>
                                                <input type="text" class="form-control form-control-sm rounded-2"
                                                    name="title" id="title" required>
                                            </div>
                                            <div class=" mb-2">
                                                <label for="description" class="form-control-label">Description</label>
                                                <textarea rows="3"
                                                    class="form-control form-control-sm rounded-2 description"
                                                    name="description" id="description" required></textarea>
                                            </div>

                                            <div class="mb-2">
                                                <label for="start_datetime" class="control-label">Start</label>
                                                <input type="datetime-local"
                                                    class="form-control form-control-sm rounded-2 flatpickr" name="start_datetime"
                                                    id="start_datetime" required placeholder="Enter Start Date">
                                            </div>
                                            <div class="mb-2">
                                                <label for="end_datetime" class="control-label">End</label>
                                                <input type="datetime-local"
                                                    class="form-control form-control-sm rounded-2 flatpickr" name="end_datetime"
                                                    id="end_datetime" required  placeholder="Enter End Date">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="text-center">
                                            <!-- Save button -->
                                            <button class="btn btn-primary btn-sm rounded-0" type="submit"
                                                form="schedule-form" id="saveButton">
                                                <i class="fa fa-save"></i> Save
                                            </button>

                                            <!-- Cancel button -->
                                            <button class="btn btn-default border btn-sm rounded-0" type="button"
                                                data-bs-dismiss="modal">
                                                <i class="fa fa-reset"></i> Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <script>
                            $(document).ready(function () {
                                $('#cancelButton').click(function () {
                                    $('#scheduleForm').hide();
                                });
                                // Update the existing script block
                                var scheds = <?= json_encode($sched_res) ?>;

                                // Event edit button click
                                $('.edit-event').click(function () {
                                    var eventId = $(this).closest('.event-container').data('id');

                                    // Populate form with existing data
                                    var eventDetails = scheds[eventId];
                                    $('#edit-schedule-form input[name="id"]').val(eventId);
                                    $('#edit-schedule-form input[name="title"]').val(eventDetails.title);
                                    $('#edit-schedule-form textarea[name="description"]').val(eventDetails.description);
                                    $('#edit-schedule-form input[name="start_datetime"]').val(eventDetails.start_datetime);
                                    $('#edit-schedule-form input[name="end_datetime"]').val(eventDetails.end_datetime);

                                    // Open the modal
                                    $('#editEventModal').modal('show');
                                });

                                // Update button click
                                $('#updateButton').click(function () {
                                    // Add any additional logic here if needed

                                    // Submit the form
                                    $('#edit-schedule-form').submit();
                                });

                            });
                        </script>


                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script
                            src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/js/bootstrap.bundle.min.js"></script>


                        <div class="col-md-12 mt-2">
                            <div class="events-wrapper">
                                <h5 class="mb-3">
                                    <center>Event List</center>
                                </h5>
                                <?php
                                $result = $conn->query("SELECT * FROM `schedule_list` WHERE teacher_class_id = $get_id ");

                                // Check if there are no events
                                if ($result->num_rows === 0) {
                                    echo "<div class='alert alert-secondary' role='alert'>";
                                    echo "<center> Post an event now! </center>";
                                    echo "</div>";
                                } else {
                                    // Display events
                                    while ($row = $result->fetch_assoc()) {
                                        $startDateTime = new DateTime($row['start_datetime']);
                                        $endDateTime = new DateTime($row['end_datetime']);
                                        $formattedStartDateTime = $startDateTime->format('F j, Y g:i A');
                                        $formattedEndDateTime = $endDateTime->format('F j, Y g:i A');
                                        echo "<div class='mb-3 event-container' data-id='{$row['id']}' data-title='{$row['title']}' data-description='{$row['description']}' data-start='{$row['start_datetime']}' data-end='{$row['end_datetime']}'>";
                                        echo "<div class='event-info'>";
                                        echo "<strong style='font-weight: 505;'>{$row['title']}</strong><br>";
                                        echo "<span>{$row['description']}</span>";
                                        echo "<span>{$formattedStartDateTime} - {$formattedEndDateTime}</span>";
                                        echo "</div>";
                                        echo "<div class='event-actions'>";
                                        echo "<button class='btn btn-sm btn-info edit-event'><i class='fas fa-pencil-alt'></i></button>";
                                        echo "<button class='btn btn-sm btn-danger delete-event'><i class='fas fa-times'></i></button>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                }
                                ?>

                            </div>
                        </div>
                        <!-- ... Existing code ... -->

                        <!-- Edit Event Modal -->
                        <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="save_schedule.php" method="post" id="edit-schedule-form">
                                            <input type="hidden" name="id" value="">
                                            <input type="hidden" name="get_id" value="<?php echo $get_id ?>">
                                            <div class="mb-3">
                                                <label for="edit-title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="edit-title" name="title"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit-description" class="form-label">Description</label>
                                                <textarea class="form-control description" id="description1"
                                                    name="description" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit-start_datetime" class="form-label">Start</label>
                                                <input type="datetime-local" class="form-control flatpickr"
                                                    id="edit-start_datetime" name="start_datetime" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit-end_datetime" class="form-label">End</label>
                                                <input type="datetime-local" class="form-control  flatpickr" id="edit-end_datetime"
                                                    name="end_datetime" required>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="updateButton">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- ... Existing code ... -->

                        <!-- Include SweetAlert library -->
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">

                        <!-- Include this script in your HTML file -->
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            $(document).ready(function () {
                                $('#toggleFormBtn').click(function () {
                                    $('#scheduleForm').toggle();
                                });

                                $('.edit-event').click(function () {
                                    var eventId = $(this).closest('.event-container').data('id');
                                    var eventDetails = scheds[eventId];

                                    $('#edit-schedule-form input[name="id"]').val(eventId);
                                    $('#edit-schedule-form input[name="title"]').val(eventDetails.title);
                                    $('#edit-schedule-form textarea[name="description"]').val(eventDetails.description);
                                    $('#edit-schedule-form input[name="start_datetime"]').val(eventDetails.start_datetime);
                                    $('#edit-schedule-form input[name="end_datetime"]').val(eventDetails.end_datetime);

                                    $('#editEventModal').modal('show');
                                });

                                $('#updateButton').click(function () {
                                    $('#edit-schedule-form').submit();
                                });

                                $('.delete-event').click(function () {
                                    var eventId = $(this).closest('.event-container').data('id');

                                    // Use SweetAlert for confirmation
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'You won\'t be able to revert this!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#3085d6',
                                        confirmButtonText: 'Yes, delete it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                type: 'POST',
                                                url: 'delete_schedule.php',
                                                data: { id: eventId },
                                                success: function (response) {
                                                    console.log(response);

                                                    if (response === 'success') {
                                                        // Use SweetAlert for success message
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Event deleted successfully!',
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                        });

                                                        // Remove the event container
                                                        $('.event-container[data-id="' + eventId + '"]').remove();
                                                    } else {
                                                        // Use SweetAlert for failure message
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Event deleted successfully!',
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                        }).then(function () {
                                                            window.location.href = 'class_calendar.php?id=' + <?php echo $get_id; ?>;
                                                        });
                                                    }
                                                },
                                                error: function () {
                                                    // Use SweetAlert for error message
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'An error occurred while deleting the event. Please try again.',
                                                    });
                                                }
                                            });
                                        }
                                    });
                                });
                            });
                        </script>






                        <?php
                        $schedules = $conn->query("SELECT * FROM `schedule_list` WHERE teacher_class_id = $get_id OR teacher_class_id = 0");
                        $sched_res = [];

                        foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
                            $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
                            $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
                            $sched_res[$row['id']] = $row;
                        }
                        ?>

                        <script>
                            var scheds = <?= json_encode($sched_res) ?>;
                        </script>


                    </div>
                </div>
            </div>
            <!-- Include this script in your HTML file -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Get references to the start and end datetime input elements
                    var startDatetimeInput = document.getElementById('start_datetime');
                    var endDatetimeInput = document.getElementById('end_datetime');

                    // Add an event listener to the start datetime input to check when its value changes
                    startDatetimeInput.addEventListener('change', function () {
                        // Parse the datetime values into Date objects
                        var startDate = new Date(startDatetimeInput.value);
                        var endDate = new Date(endDatetimeInput.value);

                        // Check if the end datetime is earlier than the start datetime
                        if (endDate < startDate) {
                            // Display a SweetAlert error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'End datetime cannot be earlier than start datetime',
                            });

                            // Reset the end datetime value to the start datetime
                            endDatetimeInput.value = startDatetimeInput.value;
                        }
                    });

                    // Add an event listener to the end datetime input to check when its value changes
                    endDatetimeInput.addEventListener('change', function () {
                        // Parse the datetime values into Date objects
                        var startDate = new Date(startDatetimeInput.value);
                        var endDate = new Date(endDatetimeInput.value);

                        // Check if the end datetime is earlier than the start datetime
                        if (endDate < startDate) {
                            // Display a SweetAlert error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'End Date cannot be earlier than Start Date',
                            });

                            // Reset the end datetime value to the start datetime
                            endDatetimeInput.value = startDatetimeInput.value;
                        }
                    });
                });
            </script>
            <!-- Include SweetAlert library -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">

            <!-- Include this script in your HTML file -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Get references to the start and end datetime input elements in the edit form
                    var editStartDatetimeInput = document.getElementById('edit-start_datetime');
                    var editEndDatetimeInput = document.getElementById('edit-end_datetime');

                    // Add an event listener to the start datetime input to check when its value changes
                    editStartDatetimeInput.addEventListener('change', function () {
                        // Parse the datetime values into Date objects
                        var startDate = new Date(editStartDatetimeInput.value);
                        var endDate = new Date(editEndDatetimeInput.value);

                        // Check if the end datetime is earlier than the start datetime
                        if (endDate < startDate) {
                            // Display a SweetAlert error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'End datetime cannot be earlier than start datetime',
                            });

                            // Reset the end datetime value to the start datetime
                            editEndDatetimeInput.value = editStartDatetimeInput.value;
                        }
                    });

                    // Add an event listener to the end datetime input to check when its value changes
                    editEndDatetimeInput.addEventListener('change', function () {
                        // Parse the datetime values into Date objects
                        var startDate = new Date(editStartDatetimeInput.value);
                        var endDate = new Date(editEndDatetimeInput.value);

                        // Check if the end datetime is earlier than the start datetime
                        if (endDate < startDate) {
                            // Display a SweetAlert error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'End datetime cannot be earlier than start datetime',
                            });

                            // Reset the end datetime value to the start datetime
                            editEndDatetimeInput.value = editStartDatetimeInput.value;
                        }
                    });
                });
            </script>

            <?php
            include('includes/scripts.php');
            include('includes/footer.php');

            ?>
        </div>
    </div>
</body>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src=".././js1/script.js"></script>

</html>