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
    $art_number = $_REQUEST["art_number"];
    $dep_id = $_REQUEST["dep_id"];
    $sqlArt = "select * from articles where art_number='$art_number' and dep_id='$dep_id'";
    $resArt = mysqli_query($conn, $sqlArt);
    $rowArt = mysqli_fetch_array($resArt);
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
                                <input type="hidden" name="art_id" value="<?php echo $rowArt["art_id"]; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>หมายเลขห้องปฏิบัติการ</label>
                                            <input type="text" name="art_number" required class="form-control" placeholder="" value="<?php echo $rowArt["art_number"]; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>แผนก</label>
                                            <select name="people_dep_id" id="people_dep_id" class="form-control" required>
                                                <option value="">--- กรุณาเลือกแผนก ---</option>
                                                <?php while ($row = mysqli_fetch_array($res)) { ?>
                                                    <option value="<?php echo $row["people_dep_id"]; ?>" <?php echo ($rowArt["dep_id"] == $row["people_dep_id"] ? 'selected' : '') ?>><?php echo $row["people_dep_name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวนที่นั่ง</label>
                                            <select class="custom-select" id="inputGroupSelect01" name="art_amount" required>
                                                <option value="" selected>-เลือกข้อมูล-</option>
                                                <option value="20" <?php echo ($rowArt["art_amount"] == '20' ? 'selected' : '') ?>>20</option>
                                                <option value="30" <?php echo ($rowArt["art_amount"] == '30' ? 'selected' : '') ?>>30</option>
                                                <option value="40" <?php echo ($rowArt["art_amount"] == '40' ? 'selected' : '') ?>>40</option>
                                            </select>
                                        </div>
                                        <?php
                                        $arrArt = explode(',', $rowArt["art_instruction"]);
                                        $lookup_art_instruction = array();
                                        foreach ($arrArt as $key => $value) {
                                            $lookup_art_instruction[$value] = true;
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label>อุปกรณ์สื่อการสอน</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="โปรเจคเตอร์" name="art_instruction[]" <?php echo (!empty($lookup_art_instruction["โปรเจคเตอร์"]) ? 'checked' : '') ?>>
                                                <label class="form-check-label">
                                                    โปรเจคเตอร์
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="ทีวี" name="art_instruction[]" <?php echo (!empty($lookup_art_instruction["ทีวี"]) ? 'checked' : '') ?>>
                                                <label class="form-check-label">
                                                    ทีวี
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="จอภาพอัจฉริยะ" name="art_instruction[]" <?php echo (!empty($lookup_art_instruction["จอภาพอัจฉริยะ"]) ? 'checked' : '') ?>>
                                                <label class="form-check-label">
                                                    จอภาพอัจฉริยะ
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="อื่นๆ" name="art_instruction[]" <?php echo (!empty($lookup_art_instruction["อื่นๆ"]) ? 'checked' : '') ?>>
                                                <label class="form-check-label">
                                                    อื่นๆ
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ชื่อห้องปฏิบัติการ</label>
                                            <input type="text" name="art_name" required class="form-control" placeholder="" value="<?php echo $rowArt["art_name"]; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวนเครื่องคอมพิวเตอร์</label>
                                            <select class="custom-select" name="art_com" required>
                                                <option selected>-เลือกข้อมูล-</option>
                                                <option value="10" <?php echo ($rowArt["art_com"] == '10' ? 'selected' : '') ?>>10</option>
                                                <option value="20" <?php echo ($rowArt["art_com"] == '20' ? 'selected' : '') ?>>20</option>
                                                <option value="30" <?php echo ($rowArt["art_com"] == '30' ? 'selected' : '') ?>>30</option>
                                                <option value="40" <?php echo ($rowArt["art_com"] == '40' ? 'selected' : '') ?>>40</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ประเภทครุภัณฑ์</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="ครุภัณฑ์พื้นฐาน" name="art_type" <?php echo ($rowArt["art_type"] == 'ครุภัณฑ์พื้นฐาน' ? 'checked' : '') ?>>
                                                <label class="form-check-label">
                                                    ครุภัณฑ์พื้นฐาน
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="ห้องปฏิบัติการเฉพาะทาง" name="art_type" <?php echo ($rowArt["art_type"] == 'ห้องปฏิบัติการเฉพาะทาง' ? 'checked' : '') ?>>
                                                <label class="form-check-label">
                                                    ห้องปฏิบัติการเฉพาะทาง
                                                </label>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary m-2" data-toggle="modal" data-target="#picBuild">ดูรูปภาพผัง</button>

                                        <div class="form-group">
                                            <label>รูปผังห้อง</label>
                                            <input type="file" class="form-control" name="art_pic" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" value="บันทึก" class="btn btn-primary" id="submit" name="update" />
                                            <!-- <input type="reset" value="ยกเลิก" class="btn btn-secondary" id="reset" name="reset" /> -->
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
<!-- Modal -->
<div class="modal fade" id="picBuild" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รูปผังห้อง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="../pic_rooms/<?php echo $rowArt["art_pic"]; ?>" alt="" width="100%" height="100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php require_once "../setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {
        $("#people_dep_id").select2({
            width: "100%",
        })
    })
</script>