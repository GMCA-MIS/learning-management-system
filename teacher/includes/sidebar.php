<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Simple Sidebar - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />

    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper" style = "margin-top: 70px;">
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?php if (basename($_SERVER['PHP_SELF']) == 'class_subjectoverview.php') echo 'active'; ?>" href="class_subjectoverview.php<?php echo '?id='.$get_id; ?>">Subject Overview</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?php if (basename($_SERVER['PHP_SELF']) == 'class_members.php') echo 'active'; ?>" href="class_members.php<?php echo '?id='.$get_id; ?>">Class Members</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?php if (basename($_SERVER['PHP_SELF']) == 'class_materials.php') echo 'active'; ?>" href="class_materials.php<?php echo '?id='.$get_id; ?>">Materials</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?php if (basename($_SERVER['PHP_SELF']) == 'class_announcements.php') echo 'active'; ?>" href="class_announcements.php<?php echo '?id='.$get_id; ?>">Announcements</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?php if (basename($_SERVER['PHP_SELF']) == 'class_calendar.php') echo 'active'; ?>" href="class_calendar.php<?php echo '?id='.$get_id; ?>">Class Calendar</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?php if (basename($_SERVER['PHP_SELF']) == 'class_assignments.php') echo 'active'; ?>" href="class_assignments.php<?php echo '?id='.$get_id; ?>">Assignments</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?php if (basename($_SERVER['PHP_SELF']) == 'class_quiz.php') echo 'active'; ?>" href="class_quiz.php<?php echo '?id='.$get_id; ?>">Quiz</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?php if (basename($_SERVER['PHP_SELF']) == 'class_exam.php') echo 'active'; ?>" href="class_exam.php<?php echo '?id='.$get_id; ?>">Exam</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?php if (basename($_SERVER['PHP_SELF']) == 'class_peta.php') echo 'active'; ?>" href="class_peta.php<?php echo '?id='.$get_id; ?>">Performance Task</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 <?php if (basename($_SERVER['PHP_SELF']) == 'class_grades.php') echo 'active'; ?>" href="class_grades.php<?php echo '?id='.$get_id; ?>">Grades </a>
                </div>
            </div>
            <!-- Page content wrapper-->

        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
