<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "../setHead.php"; ?>
    <?php
    require_once "../connect.php";
    if (empty($_SESSION["people_id"])) {
        header("location: ../index.php");
    }
    $sql = "select m.*,pd.people_dep_name from map m,people_dep pd
    where m.people_dep_id = pd.people_dep_id
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
                                            <label>แผนก</label>
                                            <select name="dep_id" id="dep_id" class="form-control" style="width: 100%">
                                                <option value="" depLevel="" pic="">--- กรุณาเลือกแผนก ---</option>
                                                <?php while ($row = mysqli_fetch_array($res)) { ?>
                                                    <option value="<?php echo $row["people_dep_id"]; ?>" depLevel="<?php echo $row["level"]; ?>" pic="<?php echo $row["pic_build"]; ?>"><?php echo "ชั้น" . $row["level"] . "-" . $row["people_dep_name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>ห้อง</label>
                                            <select name="art_id" id="art_id" class="form-control" style="width: 100%">
                                                <option value="">--- เลือกห้อง ---</option>
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
        $("#art_id").select2()
        $("#dep_id").select2()
        var picTag = 0;
        var tagNumber = 1;

        // init item
        var initImg = function(item) {
            // handle "TAP" event and add marker to image
            item.on("zoom_marker_mouse_click", function(event, position) {
                console.log("Mouse click on: " + JSON.stringify(position));
                if ($("#art_id").val() == "") {
                    $.bootstrapGrowl("กรุณาเลือกห้อง", // Messages
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
                    id: $("#art_id").val(),
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
                    value: "<h5 class='dlgPin'>" + $("#art_id option:selected").text() + "</h5>",
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
                    url: "../ajax/updateArt.php",
                    data: {
                        art_id: $("#art_id").val(),
                        level: $("#dep_id option:selected").attr("depLevel"),
                        art_x: position.x,
                        art_y: position.y,
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
                    content: 'คุณต้องการลบตำแหน่งห้อง ?',
                    buttons: {
                        confirm: function() {
                            $.ajax({
                                type: "POST",
                                url: "../ajax/updateArt.php",
                                data: {
                                    art_id: marker.param.id,
                                    art_x: 0,
                                    art_y: 0,
                                    level: 0,
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
                    url: "../ajax/getMapBuild.php",
                    data: {
                        dep_id: $("#dep_id").val(),
                        level: $("#dep_id option:selected").attr("depLevel"),
                    },
                    success: function(result) {
                        let obj = JSON.parse(result)
                        obj.forEach(element => {
                            if (element.art_x > 0 && element.art_y > 0 && element.level > 0) {
                                item.zoomMarker_AddMarker({
                                    id: element.art_id,
                                    src: "../img/marker.svg",
                                    x: element.art_x,
                                    y: element.art_y,
                                    size: 30,
                                    dialog: {
                                        value: element.nameArt,
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
                    url: "../ajax/updateArt.php",
                    data: {
                        art_id: position.markerObj.param.id,
                        level: $("#dep_id option:selected").attr("depLevel"),
                        art_x: position.x,
                        art_y: position.y,
                    },
                    success: function(result) {
                        if (result == "success") {
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
        $("#dep_id").change(function() {
            $.ajax({
                type: 'POST',
                url: "../ajax/getBuild.php",
                data: {
                    dep_id: $("#dep_id").val()
                },
                success: function(response) {
                    let obj = JSON.parse(response)
                    $("#art_id").empty();
                    $("#art_id").append('<option value="">--- เลือกห้อง ---</option>')
                    $.each(obj, function(index, value) {
                        $("#art_id").append("<option value='" + value.art_id + "' > " +
                            value.nameArt + "</option>")
                    });

                    $("#art_id").select2({
                        width: '100%'
                    });
                },
            });
            $('#zoom-marker-img').zoomMarker_CleanMarker();
            // $('#zoom-marker-img').zoomMarker_CanvasClean();
            // $('#zoom-marker-img').zoomMarker_EnableDrag(false);
            if ($("#dep_id option:selected").attr("pic") == "") {
                $('#zoom-marker-img').zoomMarker_LoadImage("../img/notBuild.jpg");
            } else {
                console.log("NO PIC")
                $('#zoom-marker-img').zoomMarker_LoadImage("../pic_buildings/" + $("#dep_id option:selected").attr("pic"));
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