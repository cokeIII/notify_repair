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

                    <!-- Outer Row -->
                    <div class="row justify-content-center">

                        <div class="col-md-12">

                            <div class="card o-hidden border-0 shadow-lg">
                                <div class="card-body p-0">
                                    <!-- Nested Row within Card Body -->
                                    <div class="row">
                                        <div class="col-md-6 d-none d-md-block logo-login">
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="border-left p-5 mt-3 mb-3">
                                                <div class="text-center">
                                                    <h1 class="h4 text-gray-900 mb-4">ระบบแจ้งซ่อม</h1>
                                                </div>
                                                <form class="user">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="people_id" placeholder="รหัสบัตรประชาชน">
                                                    </div>
                                                    <a href="#" class="btn btn-primary btn-user btn-block" id="btnLogin">
                                                        Login
                                                    </a>
                                                    <div class="mt-5 h-alert">
                                                        <p class="text-danger text-center" id="alertLogin">รหัสบัตรประชาชน ไมู่กต้อง</p>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
        $("#alertLogin").hide()
        $("#btnLogin").click(function() {
            if ($("#people_id").val()) {
                $.ajax({
                    type: "POST",
                    url: "queryLogin.php",
                    data: {
                        people_id: $("#people_id").val()
                    },
                    success: function(result) {
                        if (result.trim() == "ok") {
                            window.location.replace("repair/repair.php");
                        } else {
                            $("#alertLogin").fadeIn(3000, function() {
                                $("#alertLogin").fadeOut(5000)
                            })
                        }
                    }
                });
            } else {
                $("#alertLogin").fadeIn(3000, function() {
                    $("#alertLogin").fadeOut(5000)
                })
            }
        })
    })
</script>