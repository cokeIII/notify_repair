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
<input type="hidden" id="dep_id" value="<?php echo $_REQUEST["dep_id"]; ?>">
<input type="hidden" id="level" value="<?php echo $_REQUEST["level"]; ?>">

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
                $.redirect("repairRoom.php", {
                    art_number: marker.param.art_number + "",
                    dep_id: $("#dep_id").val()
                });
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
                    url: "../ajax/getMapBuild.php",
                    data: {
                        dep_id: $("#dep_id").val(),
                        level: $("#level").val()
                    },
                    success: function(result) {
                        let obj = JSON.parse(result)
                        obj.forEach(element => {
                            if (element.art_x > 0 && element.art_y > 0) {
                                item.zoomMarker_AddMarker({
                                    id: element.art_id,
                                    art_number: element.art_number,
                                    src: "../img/marker.svg",
                                    x: element.art_x,
                                    y: element.art_y,
                                    size: 40,
                                    dialog: {
                                        value: element.nameArt,
                                        style: {
                                            color: "black"
                                        }
                                    },
                                    hint: {

                                    },
                                    draggable: false
                                });
                            }
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
        if (!UrlExists("../pic_buildings/" + $("#dep_id").val() + "_" + $("#level").val() + ".jpg")) {
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
                src: "../pic_buildings/" + $("#dep_id").val() + "_" + $("#level").val() + ".jpg",
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