<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "../setHead.php"; ?>
    <?php
    require_once "../connect.php";
    if (empty($_SESSION["people_id"])) {
        header("location: ../index.php");
    }
    $sql = "select art_number,art_name,dep_id from articles";
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
                                            <label>ห้อง</label>
                                            <select name="art_number" id="art_number" class="form-control" style="width: 100%">
                                                <option value="">--- กรุณาเลือกห้อง ---</option>
                                                <?php while ($row = mysqli_fetch_array($res)) { ?>
                                                    <option dep_id="<?php echo $row["dep_id"]; ?>" value="<?php echo $row["art_number"]; ?>"><?php echo $row["art_number"] . ' ' . $row["art_name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>อุปกรณ์</label>
                                            <select name="equ_number" id="equ_number" class="form-control" style="width: 100%">
                                                <option value="">--- เลือกอุปกรณ์ ---</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.container-fluid -->
                        </div>
                    </div>
                    <!-- End of Main Content -->
                </div>
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
    </div>
</body>

<?php require_once "../setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {
        $("#art_number").select2()
        $("#equ_number").select2()
        var picTag = 0;
        var tagNumber = 1;

        // init item
        var initImg = function(item) {
            // handle "TAP" event and add marker to image
            item.on("zoom_marker_mouse_click", function(event, position) {
                console.log("Mouse click on: " + JSON.stringify(position));
                if ($("#equ_number").val() == "") {
                    $.bootstrapGrowl("กรุณาเลือกอุปกรณ์", // Messages
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
                    id: $("#equ_number").val(),
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
                    value: "<h5 class='dlgPin'>" + $("#equ_number option:selected").text() + "</h5>",
                    offsetX: 20,
                    style: {
                        //"border-color": "#111212"
                        color: "black",
                        // backgroundColor:"lightgray"
                        zIndex: 999,
                    }
                };
                // 画线
                $.ajax({
                    type: "POST",
                    url: "../ajax/updateEqu.php",
                    data: {
                        equ_number: $("#equ_number").val(),
                        equ_x: position.x,
                        equ_y: position.y,
                    },
                    success: function(result) {
                        if (result == "success") {
                            // $("#art_id").val("").trigger('change')
                            $.bootstrapGrowl("บันทึกข้อมูลสำเร็จ", // Messages
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
                            $.bootstrapGrowl("บันทึกข้อมูลไม่สำเร็จ", // Messages
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
                    content: 'คุณต้องการลบตำแหน่งอุปกรณ์ ?',
                    buttons: {
                        confirm: function() {
                            $.ajax({
                                type: "POST",
                                url: "../ajax/updateEqu.php",
                                data: {
                                    equ_number: marker.param.id,
                                    equ_x: 0,
                                    equ_y: 0,
                                },
                                success: function(result) {
                                    if (result == "success") {
                                        $(".zoom-marker-hover-dialog").hide()
                                        $('#zoom-marker-img').zoomMarker_RemoveMarker(marker.id);
                                        // $("#art_id").val("").trigger('change')
                                        $.bootstrapGrowl("บันทึกข้อมูลสำเร็จ", // Messages
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
                                        $.bootstrapGrowl("บันทึกข้อมูลไม่สำเร็จ", // Messages
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
                    url: "../ajax/getEqu.php",
                    data: {
                        art_number: $("#art_number").val()
                    },
                    success: function(result) {
                        let obj = JSON.parse(result)
                        obj.forEach(element => {
                            if (element.equ_x > 0 && element.equ_y > 0) {
                                item.zoomMarker_AddMarker({
                                    id: element.equ_number,
                                    src: "../img/marker.svg",
                                    x: element.equ_x,
                                    y: element.equ_y,
                                    size: 30,
                                    dialog: {
                                        value: element.equ_number + "_" + element.equ_name,
                                        style: {
                                            color: "black"
                                        }
                                    },
                                    hint: {

                                    }
                                });
                            }

                        });
                    }
                });
            });

            // message after at the end of Maker moving action
            item.on("zoom_marker_move_end", function(event, position) {
                $.ajax({
                    type: "POST",
                    url: "../ajax/updateEqu.php",
                    data: {
                        equ_number: $("#equ_number").val(),
                        equ_x: position.x,
                        equ_y: position.y,
                    },
                    success: function(result) {
                        if (result == "success") {
                            // $("#art_id").val("").trigger('change')
                            $.bootstrapGrowl("บันทึกข้อมูลสำเร็จ", // Messages
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
                            $.bootstrapGrowl("บันทึกข้อมูลไม่สำเร็จ", // Messages
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
            })
        }
        $("#art_number").change(function() {
            $.ajax({
                type: 'POST',
                url: "../ajax/getEqu.php",
                data: {
                    art_number: $("#art_number").val()
                },
                success: function(response) {
                    let obj = JSON.parse(response)
                    $("#equ_number").empty();
                    $("#equ_number").append('<option value="">--- เลือกอุปกรณ์ ---</option>')
                    $.each(obj, function(index, value) {
                        $("#equ_number").append("<option value='" + value.equ_number + "' > " +
                            value.equ_number + '_' + value.equ_name + "</option>")
                    });

                    $("#equ_number").select2({
                        width: '100%'
                    });
                },
            });
            $('#zoom-marker-img').zoomMarker_CleanMarker();
            // $('#zoom-marker-img').zoomMarker_CanvasClean();
            // $('#zoom-marker-img').zoomMarker_EnableDrag(false);
            if (!UrlExists("../pic_rooms/" + $("#art_number").val() + '_' + $("#art_number option:selected").attr("dep_id") + ".jpg")) {
                $('#zoom-marker-img').zoomMarker_LoadImage("../img/notBuild.jpg");
            } else {
                $('#zoom-marker-img').zoomMarker_LoadImage("../pic_rooms/" + $("#art_number").val() + '_' + $("#art_number option:selected").attr("dep_id") + ".jpg");
            }
        })
        initImg($('#zoom-marker-img'));

        /******************** INIT ZoomMarker here *****************************/
        $('#zoom-marker-img').zoomMarker({
            src: "../img/notBuild.jpg",
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

    function UrlExists(url) {
        var http = new XMLHttpRequest();
        http.open('HEAD', url, false);
        http.send();
        return http.status != 404;
    }
</script>