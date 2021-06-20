<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "../setHead.php"; ?>
    <?php
    if (empty($_SESSION["people_id"])) {
        header("location: ../index.php");
    }
    ?>
</head>
<input type="hidden" id="art_number" value="<?php echo $_REQUEST["art_number"]; ?>">
<input type="hidden" id="dep_id" value="<?php echo $_REQUEST["dep_id"]; ?>">

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
                    <div id="zoom-marker-div" class="zoom-marker-div">
                        <img class="zoom-marker-img" id="zoom-marker-img" alt="zoom-marker-img" name="zoom-marker-img" draggable="false">
                    </div>
                    <!-- /.container-fluid -->
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
    <a class=" scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>
<!-- Modal -->
<div class="modal fade layer-9999" id="repairEqu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แจ้งซ่อมอุปกรณ์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >รายละเอียดอาการความเสียหาย</label>
                            <textarea name="repair_des" id="" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">ส่งข้อมูล</button>
            </div>
        </div>
    </div>
</div>
<?php require_once "../setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {
        var picTag = 0;
        var tagNumber = 1;

        //init item
        var initImg = function(item) {
            // handle "TAP" event and add marker to image
            item.on("zoom_marker_mouse_click", function(event, position) {
                console.log("Mouse click on: " + JSON.stringify(position));
            });

            // listen to marker click event, print to console and delete the marker
            item.on("zoom_marker_click", function(event, marker) {
                $('#repairEqu').modal('show');
            });

            // message for the beginning of image loading process
            item.on("zoom_marker_img_load", function(event, src) {
                console.log("loading started for image : " + src);
                EasyLoading.show({
                    text: $("<span>loading image</span>"),
                    button: $("<span>dismiss</span>"),
                    type: EasyLoading.TYPE.PACMAN
                });
            });

            // message for image loaded
            item.on("zoom_marker_img_loaded", function(event, size) {
                console.log("image has been loaded with size: " + JSON.stringify(size));
                // we have to set a timer in order to watching the loader in local environment, cause the loading speed is too fast
                setTimeout(function() {
                    EasyLoading.hide();
                }, 1000);
                $.ajax({
                    type: "POST",
                    url: "../ajax/getEqu.php",
                    data: {
                        art_number: $("#art_number").val(),
                    },
                    success: function(result) {
                        let obj = JSON.parse(result)
                        obj.forEach(element => {
                            item.zoomMarker_AddMarker({
                                id: element.equ_number,
                                src: "../img/marker.svg",
                                x: element.equ_x,
                                y: element.equ_y,
                                size: 40,
                                dialog: {
                                    value: element.equ_number + "_" + element.equ_name,
                                    style: {
                                        color: "black"
                                    }
                                },
                                hint: {

                                },
                                draggable: false
                            });
                        });
                    }
                });
            });

            // message after at the end of Maker moving action
            item.on("zoom_marker_move_end", function(event, position) {
                console.log(position.markerObj.param.id);
            })
        }

        initImg($('#zoom-marker-img'));

        /******************** INIT ZoomMarker here *****************************/
        if (!UrlExists("../pic_rooms/" + $("#art_number").val() + "_" + $("#dep_id").val() + ".jpg")) {
            $('#zoom-marker-img').zoomMarker({
                src: "../img/emptyRoom.jpg",
                rate: 0.2,
                width: "50%",
                height: "50%",
                max: "100%",
                markers: [
                    //{src:"../img/marker.svg", x:300, y:300}
                ]
            });
        } else {
            $('#zoom-marker-img').zoomMarker({
                src: "../pic_rooms/" + $("#art_number").val() + "_" + $("#dep_id").val() + ".jpg",
                rate: 0.2,
                width: "50%",
                height: "50%",
                max: "100%",
                markers: [
                    //{src:"../img/marker.svg", x:300, y:300}
                ]
            });
        }
    })

    function UrlExists(url) {
        var http = new XMLHttpRequest();
        http.open('HEAD', url, false);
        http.send();
        return http.status != 404;
    }
</script>