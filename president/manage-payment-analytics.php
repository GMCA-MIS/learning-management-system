<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>


<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow newtopbar" style="margin-bottom:0;">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">Income Growth</h1>
                
            </div>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <?php include('includes/admin_name.php'); ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="card-body">

            <div class="table-responsive">




                <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                    <h1 class="h5 mb-0 text-gray-800"></h1>
                </div>  
                <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="form-group mr-5">
                            <label for="strand">Track by Strand</label>
                            <select type="text" class="form-control" id="selstrand" name="selstrand" required>
                                <option class="form-control" disabled selected> Select Strand </Option>
                                <option class="form-control" value="ALL"> ALL </Option>
                                <?php
                                    $query = mysqli_query($conn, "SELECT * FROM strand ORDER BY id DESC");
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mr-5">
                            <label for="strand">Track By Range</label>
                            <select type="text" class="form-control" id="selrange" name="selrange" required>
                                <option class="form-control" value="" disabled selected> -- Select Range -- </Option>
                                <option class="form-control" value="all-years"> All Records</Option>
                                <option class="form-control" value="current-year"> Current Year</Option>

                            </select>
                        </div>
                        <!--
                        <div class="form-group mr-5">
                            <label for="strand">Track by Gender</label>
                            <select type="text" class="form-control" id="selgender" name="selgender" required>
                                <option class="form-control" value="" disabled selected> -- Select Gender --  </Option>
                                <option class="form-control" value="male"> Male </Option>
                                <option class="form-control" value="female"> Female </Option>
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="strand">Track by Grade</label>
                            <select type="text" class="form-control" id="selgrade" name="selgrade" required>
                                <option class="form-control" value="" disabled selected> -- Select Grade --  </Option>
                                <option class="form-control" value="11"> Grade 11 </Option>
                                <option class="form-control" value="12"> Grade 12 </Option>
                            </select>
                        </div>
                                    -->
                        <div class="form-group ">
                            <button class="form-control btn btn-primary mt-4 ml-3" id="printimage" name="printimage" onclick="location.reload();" >Reload</button>

                        </div>

                    </div>
                    
                    <div class="d-sm-flex align-items-center justify-content-between" style="margin-top: 10px; margin-right: 20px;">
                            <button class="form-control btn btn-primary" id="printimage" name="printimage" >Print</button>
                    </div>
                </div>


                
                <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                        <canvas id="myChart"></canvas>
                </div>
                

            </div>
        </div>




        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <?php
        include('includes/scripts.php');
        include('includes/footer.php');
        ?>





        <script>

            $(document).ready(function() {

                //const ctx = document.getElementById('myChart');
                const ctx = document.getElementById('myChart');
                var currentchart ;
                var strand = document.getElementById('selstrand');
                var range = document.getElementById('selrange');
                //var gender = document.getElementById('selgender');
                //var grade = document.getElementById('selgrade');
                var valuestrand;
                var valuerange;
                var valuegender;
                var valuegrade;
                var parameter = ""; // get method paramater

                $("#selrange").attr("disabled", true);
                //$("#selgender").attr("disabled", true);
                //$("#selgrade").attr("disabled", true);

                document.getElementById("selstrand").onchange = triggerchangedrops;
                document.getElementById("selrange").onchange = triggerchangedrops;
                //document.getElementById("selgender").onchange = triggerchangedrops;
                //document.getElementById("selgrade").onchange = triggerchangedrops;

                function triggerchangedrops(){
                    
                    $("#selrange").attr("disabled", false);
                    $("#selgender").attr("disabled", false);
                    $("#selgrade").attr("disabled", false);

                    valuestrand = strand.options[strand.selectedIndex].value;
                    valuerange = range.options[range.selectedIndex].value;
                    valuegender = gender.options[gender.selectedIndex].value;
                    valuegrade = grade.options[grade.selectedIndex].value;
                    // clear previos chart
                    if (currentchart) {    
                        currentchart.destroy();  
                    }
                    if(valuerange != ""){
                        parameter = parameter + "&range=" +  valuerange ; 
                    }
                    if(valuegender != ""){
                        parameter = parameter + "&gender=" +  valuegender ; 
                    }
                    if(valuegrade != ""){
                        parameter = parameter + "&grade=" +  valuegrade ; 
                    }

                    if(valuestrand =='ALL'){
                        bargraph("strand=ALL" + parameter);

                    }else if(valuestrand !='ALL' ){
                        linegraph("strand="+valuestrand + parameter);
                    }
                }
                function bargraph(value){
                    
                    $.ajax({
                    url: 'parse-chart-v1.php?'+ value,
                    type: "GET",
                    dataType: "text",
                    success: function (data) {
                        //alert(data);
                        
                        const datas = JSON.parse(data);
                        currentchart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                        labels: datas.map(row => row.year),
                        datasets: [{
                            label: 'Population growth under strand',
                            data: datas.map(row => row.count),
                            borderWidth: 1,
                            backgroundColor: '#9BD0F5',
                        }]
                            },
                            options: {
                            scales: {
                                y: {
                                beginAtZero: true
                                }
                            }
                            }
                        });

                    }});
                }
                function linegraph(value){

                     $.ajax({
                     url: 'parse-chart-v1.php?'+ value,
                     type: "GET",
                     dataType: "text",
                     success: function (data) {
                        //alert(data);
                         
                         const datas = JSON.parse(data);
                         currentchart = new Chart(ctx, {
                         type: 'line',
                         data: {
                         labels: datas.map(row => row.year),
                         datasets: [{
                             label: 'Population growth under strand',
                             data: datas.map(row => row.count),
                             borderWidth: 1,
                             backgroundColor: '#9BD0F5',
                         }]
                             },
                             options: {
                             scales: {
                                 y: {
                                 beginAtZero: true
                                 }
                             }
                             }
                         });
 
                     }});
                 }

                
                /*
                const data = [
                    { year: 2010, count: 10 },
                    { year: 2011, count: 20 },
                    { year: 2012, count: 15 },
                    { year: 2013, count: 25 },
                    { year: 2014, count: 22 },
                    { year: 2015, count: 30 },
                    { year: 2016, count: 28 },
                ];
                */
                

                document.getElementById("printimage").onclick = PrintImage;
                function PrintImage() {
                        var win = window.open();
                        win.document.write("<br><img src='" + ctx.toDataURL() + "'/>");
                        //win.print();
                        //win.location.reload();
                        setTimeout(() => {
                        win.print();
                        }, 1000);
                }

                $('.edit_btn').on('click', function() {

                    $('#editProcessModal').modal('show');

                    $tr = $(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();

                    console.log(data);

                    //ID attribute ang kinukuha
                    $('#edit_ID').val(data[0]);
                    $('#o_ID').val(data[1]);
                    $('#edit_Process_Name').val(data[2]);
                    $('#edit_Process_Description').val(data[3]);
                    $('#edit_Process_Type').val(data[4]);
                });
            });
        </script>