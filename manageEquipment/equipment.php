<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "../setHead.php"; ?>
    <?php
    require_once "../connect.php";
    if (empty($_SESSION["people_id"])) {
        header("location: ../index.php");
    }
    $sql = "select equ.*,concat(art.art_number,' ',art.art_name) as artName from equipment equ, articles art
    where equ.art_number = art.art_number";
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
                            <div class="row mt-3 ml-3"><a href="formInsertEqu.php" class="txt-link"><button class="btn btn-primary ">เพิ่มข้อมูล</button></a></div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <table class="" id="equTable">
                                        <thead>
                                            <tr>
                                                <th>หมายเลขอุปกรณ์</th>
                                                <th>รายการ</th>
                                                <th>สถานะ</th>
                                                <th>ห้องปฏิบัติการ</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $row["equ_number"]; ?></td>
                                                        <td><?php echo $row["equ_name"]; ?></td>
                                                        <td><?php echo $row["equ_status"]; ?></td>
                                                        <td><?php echo $row["artName"]; ?></td>
                                                        <td><a href="formEditEquipment.php?equ_number=<?php echo $row["equ_number"] ?>"><button class="btn btn-warning"><i class="fas fa-edit"></i></button></a></td>
                                                        <td><button class="btn btn-danger delEqu" equ_number="<?php echo $row["equ_number"] ?>" ><i class="icon-color fa fa-trash"></i></button></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
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
        $("#equTable").DataTable()

        $(".delEqu").click(function() {
            let equ_number = $(this).attr("equ_number")
            $.confirm({
                title: 'delete',
                content: 'คุณต้องการลบอุปกรณ์ ?',
                buttons: {
                    confirm: function() {
                        $.redirect("sqlEquipment.php", {
                            delEqu: true,
                            equ_number: equ_number,
                        });
                    },
                    cancel: function() {

                    },
                }
            });
        })

    })
</script>