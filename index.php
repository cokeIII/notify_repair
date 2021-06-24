<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "setHead.php"; ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once "sideBar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php require_once "topBar.php"; ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <?php
                        require_once "connect.php";
                        $sqlEqu = "select count(equ_number) as equCount from equipment";
                        $resEqu = mysqli_query($conn, $sqlEqu);
                        $rowEqu = mysqli_fetch_array($resEqu);
                        ?>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-md-4 mt-2">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class=" font-weight-bold text-primary text-uppercase mb-1">
                                                อุกรณ์ทั้งหมด</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $rowEqu["equCount"] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-desktop fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $sqlEquRD = "select count(equ_number) as equCount from equipment where equ_status = 'ปกติ'";
                        $resEquRD = mysqli_query($conn, $sqlEquRD);
                        $rowEquRD = mysqli_fetch_array($resEquRD);
                        ?>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-md-4 mt-2">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-weight-bold text-success text-uppercase mb-1">
                                                อุปกรณ์ที่ใช้งานได้</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $rowEquRD["equCount"]; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-desktop fa-2x text-gray-300 opacity-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $sqlEquRep = "select count(equ_number) as equCount from equipment where equ_status = 'รายการส่งซ่อม'";
                        $resEquRep = mysqli_query($conn, $sqlEquRep);
                        $rowEquRep = mysqli_fetch_array($resEquRep);
                        ?>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-md-4 mt-2">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-weight-bold text-danger text-uppercase mb-1">อุปกรณ์ที่แจ้งซ่อม
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $rowEquRep["equCount"]; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-weight-bold text-warning text-uppercase mb-1">
                                            อุปกรณ์ที่กำลังซ่อม</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-toolbox fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <?php
                    $sqlListEqu = "select 
                        equ.equ_number,
                        equ.equ_name,
                        equ.equ_description,
                        peo.people_dep_name,
                        art.dep_id,
                        art.art_number,
                        equ_status,
                        concat(art.art_number,' ',art.art_name) as art_number_name
                        from equipment equ,people_dep peo,articles art
                        where  
                        equ.art_number = art.art_number and
                        art.dep_id = peo.people_dep_id";
                    $resListEqu = mysqli_query($conn, $sqlListEqu);

                    ?>
                    <!-- Content Row -->
                    <div class="card shadow mt-4">
                        <div class="card-body">
                            <table class="table" id="listEquipment">
                                <thead>
                                    <th>หมายเลขอุปกรณ์</th>
                                    <th>ชื่ออุปกรณ์</th>
                                    <th>เลขห้อง</th>
                                    <th>สถานะ</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    while ($rowListEqu = mysqli_fetch_array($resListEqu)) {
                                        $listStatus = "";
                                        if ($rowListEqu["equ_status"] == "รายการส่งซ่อม") {
                                            $listStatus = "text-warning";
                                        } else if ($rowListEqu["equ_status"] == "ยกเลิกรายการ" || $rowListEqu["equ_status"] == "ใช้งานไม่ได้") {
                                            $listStatus = "text-danger";
                                        } else if ($rowListEqu["equ_status"] == "กำลังดำเนินการซ่อม") {
                                            $listStatus = "text-secondary";
                                        } else if ($rowListEqu["equ_status"] == "สำเร็จ" || $rowListEqu["equ_status"] == "ปกติ") {
                                            $listStatus = "text-success";
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $rowListEqu["equ_number"]; ?></td>
                                            <td><?php echo $rowListEqu["equ_name"]; ?></td>
                                            <td><?php echo $rowListEqu["art_number"]; ?></td>
                                            <td class="<?php echo $listStatus; ?>"><?php echo $rowListEqu["equ_status"]; ?></td>
                                        </tr>
                                    <?php } ?>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>เลขห้อง</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </tfoot>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once "footer.php"; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>
<?php require_once "setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {
        $("#listEquipment").DataTable({
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    console.log(column)
                    if (column.selector.cols != 0 && column.selector.cols != 1) {
                        var select = $('<select class="form-control"><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    }
                });
            }
        })
    })
</script>