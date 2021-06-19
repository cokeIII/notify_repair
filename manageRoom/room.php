<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "../setHead.php"; ?>
    <?php
    require_once "../connect.php";
    if (empty($_SESSION["people_id"])) {
        header("location: ../index.php");
    }
    $sql = "select * from articles";
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
                                    <table class="" id="artTable">
                                        <thead>
                                            <tr>
                                                <th>หมายเลขห้องปฏิบัติการ</th>
                                                <th>ชื่อห้องปฏิบัติการ</th>
                                                <th>จำนวนเครื่องคอมพิวเตอร์</th>
                                                <th>อุปกรณ์สื่อการสอน</th>
                                                <th>แผนก</th>
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
                                                        <td><?php echo $row["art_number"] ?></td>
                                                        <td><?php echo $row["art_name"] ?></td>
                                                        <td><?php echo $row["art_com"] ?></td>
                                                        <td><?php echo $row["art_instruction"] ?></td>
                                                        <td><?php echo $row["dep_id"] ?></td>
                                                        <td><button class="btn btn-warning"><a href="formEditArt.php?art_id=<?php echo $row["art_id"] ?>"><i class="icon-color fa fa-pencil-square"></i></a></button></td>
                                                        <td><button class="btn btn-danger"><a href="sqlArticles.php?art_id=<?php echo $row["art_id"] ?>&delArt=true"><i class="icon-color fa fa-trash"></i></a></button></td>
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
        $("#artTable").DataTable()
    })
</script>