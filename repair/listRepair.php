<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "../setHead.php"; ?>
    <?php
    require_once "../connect.php";
    if (empty($_SESSION["people_id"])) {
        header("location: ../index.php");
    }
    $sql = "select * from repair rep, equipment equ where rep.equ_number = equ.equ_number";
    $result = mysqli_query($conn, $sql);
    ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once "../sideBar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php require_once "../topBar.php"; ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mt-3 ml-3"><a href="formInsertArticles.php" class="txt-link"><button class="btn btn-primary ">เพิ่มข้อมูล</button></a></div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <table class="" id="listRepair">
                                        <thead>
                                            <tr>
                                                <!-- <th>หมายเลขอุปกรณ์</th> -->
                                                <th>ชื่ออุปกรณ์</th>
                                                <th>รายระเอียดที่แจ้ง</th>
                                                <th>สถานะ</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <!-- <td><?php //echo $row["equ_number"] ?></td> -->
                                                        <td><?php echo $row["equ_name"] ?></td>
                                                        <td><?php echo $row["rep_description"] ?></td>
                                                        <td><?php echo $row["rep_status"] ?></td>
                                                        <?php if ($row["rep_status"] == "รายการส่งซ่อม") { ?>
                                                            <td><button class="btn btn-danger cancelRepair" equ_number="<?php echo $row["equ_number"] ?>"><i class="fas fa-window-close"></i> ยกเลิก</button></td>
                                                        <?php } else { ?>
                                                            <td></td>
                                                        <?php } ?>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>หมายเลขอุปกรณ์</th>
                                                <th>ชื่ออุปกรณ์</th>
                                                <th>รายระเอียดที่แจ้ง</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once "../footer.php"; ?>
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
<?php require_once "../setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {
        $("#listRepair").DataTable({
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
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
                });
            }
        })
        $(".cancelRepair").click(function() {
            let equ_number = $(this).attr("equ_number")
            $.confirm({
                title: 'Cancel',
                content: 'คุณต้องการยกเลิกรายการ ?',
                buttons: {
                    confirm: function() {
                        $.redirect("../ajax/sqlRepair.php", {
                            equ_number: equ_number,
                            cancel: true
                        });
                    },
                    cancel: function() {

                    },
                }
            });
        })

    })
</script>