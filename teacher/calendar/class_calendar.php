<?php require_once('db-connect.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fullcalendar/lib/main.min.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="fullcalendar/lib/main.min.js"></script>
	<link rel="stylesheet" href="css/style.css">
	<link href='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css' rel='stylesheet'>
	<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
	<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/js/bootstrap.min.js"></script>
	<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js'></script>
    <style>
   <style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700&display=swap');
*{
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

table, tbody, td, tfoot, th, thead, tr {
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

/* COLOR NG MONTH BUTTON NG CALENDAR */
.fc-dayGridMonth-button.btn.btn-primary {
    background-color: #001f3f; 
    color: white; 
}
/* COLOR NG WEEK BUTTON NG CALENDAR */
.fc-dayGridWeek-button.btn.btn-primary {
    background-color: #001f3f; 
}
/* COLOR NG LIST BUTTON NG CALENDAR */
.fc-list-button.btn.btn-primary {
    background-color: #001f3f; 
}
/* COLOR NG TODAY BUTTON NG CALENDAR */
.fc-today-button.btn.btn-primary {
    background-color: #001f3f; 
}
/* COLOR NG MGA BUTTON SA CALENDAR */
.btn.btn-primary {
    background-color: #001f3f; 
}


/* ---------------- SCHEDULE FORM---------------------- */
/* ADD SCHEDULE BUTTON OF SCHEDULE FORM */
#toggleFormBtn {
        background-color: #001f3f; 
}

/* FOOTER NG SCHEDULE FORM */
.card-footer {
    background-color: white; /* Set white background for the card-footer */
    padding: 10px; /* Add some padding to the card-footer, adjust as needed */
}

#saveButton {
    background-color: #001f3f; /* Darker navy blue */
    color: #fff; /* Set text color to white */
}

#cancelButton {
    background-color: gray; /* Set gray background for the Cancel button */
    color: #fff; /* Set text color to black */
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
    justify-content: space-between; /* Add this line */
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

    <?php
    include('includes/topbar.php');
    include('includes/header.php');
    include('includes/navbar.php');
    include('includes/sidebar.php');
    include('dbcon.php');
    ?>

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
                <button type="button" class="btn btn-primary mb-3" id="toggleFormBtn" data-bs-toggle="modal" data-bs-target="#scheduleForm">
                    Add Schedule
                </button>
            </div>
					
					
              
				 <!-- Form -->
				
                <<!-- Form -->
            <div class="modal fade" id="scheduleForm" tabindex="-1" aria-labelledby="scheduleFormLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="scheduleFormLabel">Add Schedule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: white;">
                            <div class="container-fluid">
                                <form action="save_schedule.php" method="post" id="schedule-form">
                                <input type="hidden" name="id" value="">
                                <div class="form-group mb-2">
                                    <label for="title" class="control-label">Title</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="description" class="control-label">Description</label>
                                    <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="start_datetime" class="control-label">Start</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="end_datetime" class="control-label">End</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                </div>
                           </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="text-center">
                                <!-- Save button -->
                                <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form" id="saveButton">
                                    <i class="fa fa-save"></i> Save
                                </button>

                                <!-- Cancel button -->
                                <button class="btn btn-default border btn-sm rounded-0" type="button" data-bs-dismiss="modal">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/js/bootstrap.bundle.min.js"></script>

	
<div class="col-md-12 mt-2">
    <div class="events-wrapper">
        <h5 class="mb-3"><center>Event List</center></h5>
        <?php
$result = $conn->query("SELECT * FROM `schedule_list`");
while ($row = $result->fetch_assoc()) {
    echo "<div class='mb-3 event-container' data-id='{$row['id']}' data-title='{$row['title']}' data-description='{$row['description']}' data-start='{$row['start_datetime']}' data-end='{$row['end_datetime']}'>";
    echo "<div class='event-info'>";
    echo "<strong style='font-weight: 505;'>{$row['title']}</strong><br>";
    echo "<span>{$row['description']}</span>";
    echo "</div>";
    echo "<div class='event-actions'>";
    echo "<button class='btn btn-sm btn-info edit-event'><i class='fas fa-pencil-alt'></i></button>";
    echo "<button class='btn btn-sm btn-danger delete-event'><i class='fas fa-times'></i></button>";
    echo "</div>";
    echo "</div>";
	
}
?>

    </div>
</div>
<!-- ... Existing code ... -->

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="save_schedule.php" method="post" id="edit-schedule-form">
                    <input type="hidden" name="id" value="">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit-description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-start_datetime" class="form-label">Start</label>
                        <input type="datetime-local" class="form-control" id="edit-start_datetime" name="start_datetime" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-end_datetime" class="form-label">End</label>
                        <input type="datetime-local" class="form-control" id="edit-end_datetime" name="end_datetime" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateButton">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- ... Existing code ... -->

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

            
            var confirmDelete = confirm('Are you sure you want to delete this event?');

            if (confirmDelete) {
               
                $.ajax({
                    type: 'POST',
                    url: 'delete_schedule.php',
                    data: { id: eventId },
                    success: function (response) {
                        console.log(response);  

                        if (response === 'success') {
                            
                            $('.event-container[data-id="' + eventId + '"]').remove();
                        } else {
                            alert('Failed to delete the event. Please try again.');
                        }
                    },
                    error: function () {
                        alert('An error occurred while deleting the event. Please try again.');
                    }
                });
            }
        });
    });
</script>

  
	
	

<?php
$schedules = $conn->query("SELECT * FROM `schedule_list`");
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
</body>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="./js/script.js"></script>

</html>
