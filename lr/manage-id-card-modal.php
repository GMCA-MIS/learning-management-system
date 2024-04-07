<div class="modal fade" id="add_lcardkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New ID Card
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="container">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" placeholder="Full name" name="name">
                        </div>
                        <div class="col-sm-4">
                            <label for="department">Department</label>
                            <select name="dept" class="custom-select custom-select">
                                <option selected></option>
                                <option value="Computer Studies">Computer Studies</option>
                                <option value="Education">Education</option>
                                <option value="Agriculture">Agriculture</option>
                                <option value="Junior High School">Junior High School</option>
                                <option value="Senior High School">Senior High School</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="category">Category</label>
                            <select name="cat" class="custom-select custom-select">
                                <option selected></option>
                                <option value="Student">Student</option>
                                <option value="Faculty">Faculty</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" placeholder="Type your address" name="address">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" placeholder="Your email" name="email">
                        </div>
                        <div class="col-sm-6">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" name="dob">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="id">ID Card No.</label>
                            <input type="text" class="form-control" placeholder="ID No." name="id_no">
                        </div>
                        <div class="col-sm-6">
                            <label for="contact">Contact No.</label>
                            <input type="text" class="form-control" placeholder="Phone number" name="phone">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="photo">Upload Photo</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
        <!--modal content -->
    </div>
    <!--modal dialog -->
</div>
<!--modal fade -->