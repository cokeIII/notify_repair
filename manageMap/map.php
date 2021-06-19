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
                    <div class="row">
                        <div class="col-md-7">
                            <div id="zoom-marker-div" class="zoom-marker-div">
                                <img class="zoom-marker-img" id="zoom-marker-img" alt="zoom-marker-img" name="zoom-marker-img" draggable="false" />
                            </div>
                        </div>
                        <div class="col-md-5 mt-3">
                            <div class="card shadow">
                                <div class="card-body">
                                    <form id="formLocation" action="" method="post">
                                        <div class="form-group">
                                            <label>ชื่อสถานที่</label>
                                            <select name="locationName" id="locationName" class="form-control" style="width: 100%">
                                                <option value="">--- กรุณาเลือกสถานที่ ---</option>
                                                <?php while ($row = mysqli_fetch_array($res)) { ?>
                                                    <option value="<?php echo $row["people_dep_id"]; ?>"><?php echo $row["people_dep_name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>รูปผังอาคาร</label>
                                            <input type="file" class="form-control" name="picBuild" id="picBuild">
                                        </div>
                                    </form>
                                </div>
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
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
</body>

<?php require_once "../setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {
        $("#locationName").select2()
        var picTag = 0;
        var tagNumber = 1;

        // init item
        var initImg = function(item) {
            // handle "TAP" event and add marker to image
            item.on("zoom_marker_mouse_click", function(event, position) {
                console.log("Mouse click on: " + JSON.stringify(position));
                if ($("#locationName").val() == "") {
                    $.bootstrapGrowl("กรุณาเลือกสถานที่", // Messages
                        { // options
                            type: "warning", // info, success, warning and danger
                            ele: "body", // parent container
                            offset: {
                                from: "top",
                                amount: 100,
                            },
                            align: "center", // right, left or center
                            width: "auto",
                            delay: 4000,
                            allow_dismiss: true, // add a close button to the message
                            // stackup_spacing: 10
                        });
                    return false
                }

                const marker = item.zoomMarker_AddMarker({
                    id: $("#locationName").val(),
                    src: "../img/marker.svg",
                    x: position.x,
                    y: position.y,
                    size: 30,
                    dialog: {
                        // value: $("#locationName option:selected").text(),
                        // style: {
                        //     color: "black"
                        // }
                    },
                    // hint: {
                    //     value: tagNumber,
                    //     style: {
                    //         color: "#ffffff",
                    //         left: "10px"
                    //     }
                    // }
                });
                // 手动配置dialog
                marker.param.dialog = {
                    value: "<h5 class='dlgPin'>" + $("#locationName option:selected").text() + "</h5>",
                    offsetX: 20,
                    style: {
                        //"border-color": "#111212"
                        color: "black",
                        // backgroundColor:"lightgray"
                        zIndex: 999,
                    }
                };
                // 画线
                var fd = new FormData();
                var files = $('#picBuild')[0].files;

                // Check file selected or not
                if (files.length > 0) {
                    fd.append('picBuild', files[0]);
                }
                fd.append('dep_id', $("#locationName").val())
                $.ajax({
                    type: "POST",
                    url: "../ajax/uploadBuilding.php",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        let obj = JSON.parse(result)
                        $.ajax({
                            type: "POST",
                            url: "../ajax/insertMap.php",
                            data: {
                                insertMap: true,
                                people_dep_id: $("#locationName").val(),
                                map_x: position.x,
                                map_y: position.y,
                                pic_build: obj.namePic
                            },
                            success: function(result) {
                                if (result == "success") {
                                    $('#formLocation').trigger("reset");
                                    $("#locationName").val("").trigger('change')
                                    $.bootstrapGrowl("เพิ่มข้อมูลสำเร็จ", // Messages
                                        { // options
                                            type: "success", // info, success, warning and danger
                                            ele: "body", // parent container
                                            offset: {
                                                from: "top",
                                                amount: 100,
                                            },
                                            align: "center", // right, left or center
                                            width: "auto",
                                            delay: 4000,
                                            allow_dismiss: true, // add a close button to the message
                                            // stackup_spacing: 10
                                        });
                                } else {
                                    $.bootstrapGrowl("เพิ่มข้อมูลไม่สำเร็จ", // Messages
                                        { // options
                                            type: "danger", // info, success, warning and danger
                                            ele: "body", // parent container
                                            offset: {
                                                from: "top",
                                                amount: 100,
                                            },
                                            align: "center", // right, left or center
                                            width: "auto",
                                            delay: 4000,
                                            allow_dismiss: true, // add a close button to the message
                                            // stackup_spacing: 10
                                        });
                                }
                            }
                        });
                    }
                });
                const context = item.zoomMarker_Canvas();
                if (context !== null) {
                    context.strokeStyle = 'black';
                    context.moveTo(position.x, position.y);
                    context.lineTo(100, 100);
                    context.stroke();
                }
                if (++tagNumber >= 10)
                    tagNumber = 1


            });

            // listen to marker click event, print to console and delete the marker
            item.on("zoom_marker_click", function(event, marker) {
                $.confirm({
                    title: 'delete',
                    content: 'คุณต้องการลบสถานที่ ?',
                    buttons: {
                        confirm: function() {
                            $.ajax({
                                type: "POST",
                                url: "../ajax/deleteMap.php",
                                data: {
                                    delMap: true,
                                    people_dep_id: marker.param.id,
                                },
                                success: function(result) {
                                    if (result == "success") {
                                        $(".zoom-marker-hover-dialog").hide()
                                        $('#zoom-marker-img').zoomMarker_RemoveMarker(marker.id);
                                    } else {
                                        $.bootstrapGrowl("ลบไม่สำรเร็จ", // Messages
                                            { // options
                                                type: "danger", // info, success, warning and danger
                                                ele: "body", // parent container
                                                offset: {
                                                    from: "top",
                                                    amount: 100,
                                                },
                                                align: "center", // right, left or center
                                                width: "auto",
                                                delay: 4000,
                                                allow_dismiss: true, // add a close button to the message
                                                // stackup_spacing: 10
                                            });
                                    }
                                }
                            });
                        },
                        cancel: function() {

                        },
                    }
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
                }, 2000);
                $.ajax({
                    type: "POST",
                    url: "../ajax/getMap.php",
                    data: {
                        getMap: true,
                    },
                    success: function(result) {
                        let obj = JSON.parse(result)
                        obj.forEach(element => {
                            item.zoomMarker_AddMarker({
                                id: element.people_dep_id,
                                src: "../img/marker.svg",
                                x: element.map_x,
                                y: element.map_y,
                                size: 30,
                                dialog: {
                                    value: element.people_dep_name,
                                    style: {
                                        color: "black"
                                    }
                                },
                                hint: {

                                }
                            });
                        });
                    }
                });

            });

            // message after at the end of Maker moving action
            item.on("zoom_marker_move_end", function(event, position) {
                $.ajax({
                    type: "POST",
                    url: "../ajax/updateMap.php",
                    data: {
                        editMap: true,
                        people_dep_id: position.markerObj.param.id,
                        map_x: position.x,
                        map_y: position.y
                    },
                    success: function(result) {
                        if (result == "success") {
                            $.bootstrapGrowl("แก้ไขข้อมูลสำเร็จ", // Messages
                                { // options
                                    type: "success", // info, success, warning and danger
                                    ele: "body", // parent container
                                    offset: {
                                        from: "top",
                                        amount: 100,
                                    },
                                    align: "center", // right, left or center
                                    width: "auto",
                                    delay: 4000,
                                    allow_dismiss: true, // add a close button to the message
                                    // stackup_spacing: 10
                                });
                        } else {
                            $.bootstrapGrowl("แก้ไขข้อมูลไม่สำเร็จ", // Messages
                                { // options
                                    type: "danger", // info, success, warning and danger
                                    ele: "body", // parent container
                                    offset: {
                                        from: "top",
                                        amount: 100,
                                    },
                                    align: "center", // right, left or center
                                    width: "auto",
                                    delay: 4000,
                                    allow_dismiss: true, // add a close button to the message
                                    // stackup_spacing: 10
                                });
                        }
                    }
                });
                console.log(position.markerObj.param.id);
            })
        }

        initImg($('#zoom-marker-img'));

        /******************** INIT ZoomMarker here *****************************/
        $('#zoom-marker-img').zoomMarker({
            src: "../img/0002.jpg",
            rate: 0.2,
            width: "100%",
            height: "100%",
            max: "100%",
            markers: [
                //{src:"../img/marker.svg", x:300, y:300}
            ]
        });
        /******************** INIT ZoomMarker here *****************************/
    })
</script>