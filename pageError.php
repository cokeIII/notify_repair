<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "setHead.php"; ?>
</head>
<?php if(!empty($_GET["ERROR"])){
    $text_err = $_GET["ERROR"];
}?>
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
                    <!-- Content Row -->
                    <div class="card shadow mt-4">
                        <div class="card-body">
                        <h3 class="text-danger">เกิดข้อผิดพลาด</h3>
                        <h2><?php echo $text_err;?></h2>
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
    })
</script>