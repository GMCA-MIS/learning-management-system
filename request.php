<?php

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Form</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

.nav{
    background-color: #341c14 !important;
    color: #faefaa;
    text-transform: uppercase;


}
label{
    font-weight: bold;
}
</style>

<body>
<!-- nav -->
<nav class="navbar border-bottom border-body nav justify-content-center" data-bs-theme="dark">
    <h3 class="pt-2">Golden Minds Colleges and Academy</h3>
</nav>
<!-- form -->
<div class="container-fluid ">
   
<form class="m-5 p-5">
    <div class="row mb-3 text-center">
        <label class="form-label">STUDENT DETAILS</label>
    </div> 
    <!-- NAME -->
    <div class="row mb-3">
        <div class="col">
        <label  class="form-label">Last name</label>
            <input type="text" class="form-control" placeholder="Last name" aria-label="Last name">
        </div>
        <div class="col">
        <label  class="form-label">First name</label>
            <input type="text" class="form-control" placeholder="First name" aria-label="First name">
        </div>
        <div class="col">
        <label  class="form-label">Middle name</label>
            <input type="text" class="form-control" placeholder="Middle name" aria-label="Middle name">
        </div>
    </div>
    <!-- ADDRESS -->
    <div class="row mb-3">
        <div class="col">
            <label  class="form-label">Address</label>
             <input type="text" class="form-control"  placeholder="Address">
        </div>
    </div>
    <!-- PROGRAM -->
    <div class="row mb-3">
        <div class="col">
        <label  class="form-label">Course/Program</label>
            <input type="text" class="form-control"  placeholder="course/program">
        </div>
    </div>
    <!-- BIRTH -->
    <div class="row mb-5">
        <div class="col">
        <label  class="form-label">Date of Birth</label>
            <input type="date" class="form-control" placeholder="Date of Birth" >
        </div>
        <div class="col">
        <label  class="form-label">Place of Birth</label>
            <input type="text" class="form-control" placeholder="Place of Birth">
        </div>
    </div>
    <!-- ADMISSION -->
    <div class="row mb-3 text-center">
        <label class="form-label">REQUEST DETAILS</label>
    </div>      
    <div class="row mb-3">
        <div class="col">
        <label class="form-label">Credentials Submitted</label>
            <input type="text" class="form-control" placeholder="Credentials Submitted" >
        </div>
        <div class="col">
        <label class="form-label">Semester Attended</label>
            <input type="text" class="form-control" placeholder="Semester Attended" >
        </div>
    </div>
    <!-- PURPOSE -->
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Purpose of Request</label>
            <select class="form-select">
                <option selected disabled>Semester Attended</option>
                <option value="1">Employment</option>
                <option value="2">Job Application</option>
                <option value="3">Transfer to other School</option>
            </select>        
        </div>
    </div>
    <!-- REQUEST DETAILS -->
    <div class="row mb-3">
       <div class="col">
        <label  class="form-label">Date of Request and Payment</label>
            <input type="date" class="form-control" placeholder="Date of Birth" >
        </div>
        <div class="col">
        <label  class="form-label">Amount Paid</label>
            <input type="text" class="form-control" placeholder="Credentials Submitted" >
        </div>
        <div class="col">
        <label  class="form-label">OR No.</label>
            <input type="text" class="form-control" placeholder="OR No." >
        </div>
    </div>
    <!-- CONTACT -->
    <div class="row mb-3">
        <div class="col">
        <label  class="form-label">Contact  No.</label>
            <input type="text" class="form-control" placeholder="Contact No." >
        </div>
    </div>
    <!-- REQUEST DETAILS -->
    <div class="row mb-5">
        <div class="col">
        <label  class="form-label">Date to be claimed</label>
            <input type="date" class="form-control" placeholder="Date of Birth" >
        </div>
        <div class="col">
        <label  class="form-label">Request received by:</label>
            <input type="text" class="form-control" placeholder="Name of Staff">
        </div>
    </div>
    <!-- BUTTONS -->
    <div class="row mb-3 text-end">
        <div class="d-grid gap-3 d-md-block ">
            <button class="btn btn-danger px-5" type="button">Cancel</button>
            <button class="btn btn-primary px-5" type="button">Submit</button>
        </div>
    </div>


</form>
</div>

</body>
</html>