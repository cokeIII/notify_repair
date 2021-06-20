<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "../setHead.php"; ?>
    <?php
    require_once "../connect.php";
    if (empty($_SESSION["people_id"])) {
        header("location: ../index.php");
    }
    $sql = "select people_dep_id,people_dep_name from people_dep
    where people_dep_id not in ('1','2','3','4','5','330','999','888','329') 
    order by people_dep_name";
    $res = mysqli_query($conn, $sql);

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
                            <form method="POST" action="sqlArticles.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>หมายเลขห้องปฏิบัติการ</label>
                                            <input type="text" name="art_number" required class="form-control" placeholder="10-406">
                                        </div>
                                        <div class="form-group">
                                            <label>แผนก</label>
                                            <select name="people_dep_id" id="people_dep_id" class="form-control" required>
                                            <option value="">--- กรุณาเลือกแผนก ---</option>
                                            <?php while ($row = mysqli_fetch_array($res)) { ?>
                                                <option value="<?php echo $row["people_dep_id"];?>"><?php echo $row["people_dep_name"];?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวนที่นั่ง</label>
                                            <select class="custom-select" id="inputGroupSelect01" name="art_amount" required>
                                                <option value="" selected>-เลือกข้อมูล-</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>อุปกรณ์สื่อการสอน</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="โปรเจคเตอร์" name="art_instruction[]">
                                                <label class="form-check-label">
                                                    โปรเจคเตอร์
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="ทีวี" name="art_instruction[]">
                                                <label class="form-check-label">
                                                    ทีวี
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="จอภาพอัจฉริยะ" name="art_instruction[]">
                                                <label class="form-check-label">
                                                    จอภาพอัจฉริยะ
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="อื่นๆ" name="art_instruction[]">
                                                <label class="form-check-label">
                                                    อื่นๆ
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 border-left">
                                        <div class="form-group">
                                            <label>ชื่อห้องปฏิบัติการ</label>
                                            <input type="text" name="art_name" required class="form-control" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวนเครื่องคอมพิวเตอร์</label>
                                            <select class="custom-select" name="art_com" required>
                                                <option selected>-เลือกข้อมูล-</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ประเภทครุภัณฑ์</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="ครุภัณฑ์พื้นฐาน" name="art_type" checked>
                                                <label class="form-check-label">
                                                    ครุภัณฑ์พื้นฐาน
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="ห้องปฏิบัติการเฉพาะทาง" name="art_type">
                                                <label class="form-check-label">
                                                    ห้องปฏิบัติการเฉพาะทาง
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>รูปผังห้อง</label>
                                            <input type="file" class="form-control" name="art_pic" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" value="บันทึก" class="btn btn-primary" id="submit" name="insert" />
                                            <input type="reset" value="ยกเลิก" class="btn btn-secondary" id="reset" name="reset" />
                                        </div>
                                    </div>
                                </div>
                            </form>
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
        $("#people_dep_id").select2({
            width: "100%",
        })
    })
</script>