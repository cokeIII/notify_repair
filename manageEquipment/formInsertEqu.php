<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "../setHead.php"; ?>
    <?php
    require_once "../connect.php";
    if (empty($_SESSION["people_id"])) {
        header("location: ../index.php");
    }
    $sql = "select concat(art_number,' ',art_name) as artName, art_number  from articles";
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
                            <form method="POST" action="sqlEquipment.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>หมายเลขอุปกรณ์</label>
                                            <input type="text" name="equ_number" required class="form-control" placeholder="0140-001-0007/302-09">
                                        </div>
                                        <div class="form-group">
                                            <label>ชื่ออุปกรณ์</label>
                                            <input type="text" name="equ_name" required class="form-control" placeholder="Notebook acer">
                                        </div>
                                        <div class="form-group">
                                            <label>รายละเอียด</label>
                                            <textarea name="equ_description" cols="30" rows="5" class="form-control" required></textarea>
                                        </div>

                                    </div>

                                    <div class="col-md-6 border-left">
                                        <div class="form-group">
                                            <label>ราคา</label>
                                            <input type="number" name="equ_price" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>ห้องที่เก็บอปกรณ์</label>
                                            <select name="art_number" id="art_number" class="form-control" required>
                                                <option value="">--- เลือกห้อง ---</option>
                                                <?php while ($row = mysqli_fetch_array($res)) { ?>
                                                    <option value="<?php echo $row["art_number"]; ?>"><?php echo $row["artName"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>สถานะ</label>
                                            <select name="equ_status" id="equ_status" class="form-control">
                                                <option value="ปกติ">ปกติ</option>
                                                <option value="ใช้งานไม่ได้">ใช้งานไม่ได้</option>
                                            </select>
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
        $("#art_number").select2()
    })
</script>