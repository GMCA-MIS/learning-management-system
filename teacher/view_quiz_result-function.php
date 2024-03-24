<?php
include 'dbcon.php';
include 'includes/header.php';
if (isset($_POST['change_result'])) {
    // Get values from the POST data
    $studentId = $_POST['student_id'];
    $quizId = $_POST['quiz_id'];
    $quizResultId = $_POST['quiz_result_id'];

    // Fetch the current value of is_correct
    $query = "SELECT is_correct FROM quiz_results WHERE quiz_result_id = ?";

    try {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $quizResultId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentIsCorrect = $row['is_correct'];

            // Toggle the value of is_correct
            $newIsCorrect = ($currentIsCorrect == 1) ? 0 : 1;

            // Update the database with the new value
            $updateQuery = "UPDATE quiz_results SET is_correct = ? WHERE quiz_result_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ii", $newIsCorrect, $quizResultId);
            $updateResult = $updateStmt->execute();

            if ($updateResult) {
                // Calculate total points where is_correct is equal to 1
                $totalPointsQuery = "SELECT SUM(points) AS total_points
                                    FROM quiz_results
                                    WHERE quiz_id = ? AND student_id = ? AND is_correct = 1";

                $totalPointsStmt = $conn->prepare($totalPointsQuery);
                $totalPointsStmt->bind_param("ii", $quizId, $studentId);
                $totalPointsStmt->execute();
                $totalPointsResult = $totalPointsStmt->get_result();

                if ($totalPointsResult && $totalPointsResult->num_rows > 0) {
                    $totalPointsRow = $totalPointsResult->fetch_assoc();
                    $totalPoints = $totalPointsRow['total_points'];

                    // Update the grade column in student_class_quiz
                    $updateGradeQuery = "UPDATE student_class_quiz
                    SET grade = ?
                    WHERE student_id = ? AND quiz_id = ?";


                    $updateGradeStmt = $conn->prepare($updateGradeQuery);
                    $updateGradeStmt->bind_param("iii", $totalPoints, $studentId, $quizId);
                    $updateGradeResult = $updateGradeStmt->execute();

                    if ($updateGradeResult) {
                        // Success message or redirection
                        echo '<script>
                                Swal.fire({
                                    title: "Success!",
                                    text: "Result updated successfully!",
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    // Redirect or perform any other action after the user clicks
                                    window.location.href = "view_quiz_result.php?quiz_id=' . $quizId . '&id=' . $studentId . '";
                                });
                             </script>';
                    } else {
                        // Error handling for updating grade
                        echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Error updating grade: ' . $updateGradeStmt->error . '",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                             </script>';
                    }
                } else {
                    // Handle the case when no rows are returned for total points
                    echo "No total points found for quiz_id: $quizId and student_id: $studentId";
                }

                // Close the total points statement
                $totalPointsStmt->close();
            } else {
                // Error handling for updating result
                echo "Error updating result: " . $updateStmt->error;
            }
        } else {
            // Handle the case when no rows are returned for quiz_result_id
            echo "No rows found for quiz_result_id: " . $quizResultId;
        }

        // Close the update statement
        $updateStmt->close();
        // Close the original statement
        $stmt->close();
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    }
}
?>



<?php
include 'dbcon.php';
include 'includes/header.php';
if (isset($_POST['change_result_exam'])) {
    // Get values from the POST data
    $studentId = $_POST['student_id'];
    $examId = $_POST['exam_id'];
    $examResultId = $_POST['exam_result_id'];

    // Fetch the current value of is_correct
    $query = "SELECT is_correct FROM exam_results WHERE exam_result_id = ?";

    try {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $examResultId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentIsCorrect = $row['is_correct'];

            // Toggle the value of is_correct
            $newIsCorrect = ($currentIsCorrect == 1) ? 0 : 1;

            // Update the database with the new value
            $updateQuery = "UPDATE exam_results SET is_correct = ? WHERE exam_result_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ii", $newIsCorrect, $examResultId);
            $updateResult = $updateStmt->execute();

            if ($updateResult) {
                // Calculate total points where is_correct is equal to 1
                $totalPointsQuery = "SELECT SUM(points) AS total_points
                                    FROM exam_results
                                    WHERE exam_id = ? AND student_id = ? AND is_correct = 1";

                $totalPointsStmt = $conn->prepare($totalPointsQuery);
                $totalPointsStmt->bind_param("ii", $examId, $studentId);
                $totalPointsStmt->execute();
                $totalPointsResult = $totalPointsStmt->get_result();

                if ($totalPointsResult && $totalPointsResult->num_rows > 0) {
                    $totalPointsRow = $totalPointsResult->fetch_assoc();
                    $totalPoints = $totalPointsRow['total_points'];

                    // Update the grade column in student_class_exam
                    $updateGradeQuery = "UPDATE student_class_exam
                    SET grade = ?
                    WHERE student_id = ? AND exam_id = ?";


                    $updateGradeStmt = $conn->prepare($updateGradeQuery);
                    $updateGradeStmt->bind_param("iii", $totalPoints, $studentId, $examId);
                    $updateGradeResult = $updateGradeStmt->execute();

                    if ($updateGradeResult) {
                        // Success message or redirection
                        echo '<script>
                                Swal.fire({
                                    title: "Success!",
                                    text: "Result updated successfully!",
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    // Redirect or perform any other action after the user clicks
                                    window.location.href = "view_exam_result.php?exam_id=' . $examId . '&id=' . $studentId . '";
                                });
                             </script>';
                    } else {
                        // Error handling for updating grade
                        echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Error updating grade: ' . $updateGradeStmt->error . '",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                             </script>';
                    }
                } else {
                    // Handle the case when no rows are returned for total points
                    echo "No total points found for exam_id: $examId and student_id: $studentId";
                }

                // Close the total points statement
                $totalPointsStmt->close();
            } else {
                // Error handling for updating result
                echo "Error updating result: " . $updateStmt->error;
            }
        } else {
            // Handle the case when no rows are returned for exam_result_id
            echo "No rows found for exam_result_id: " . $examResultId;
        }

        // Close the update statement
        $updateStmt->close();
        // Close the original statement
        $stmt->close();
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    }
}
?>
