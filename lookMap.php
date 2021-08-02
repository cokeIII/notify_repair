<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "setHead.php"; ?>
</head>
<?php
$equ_number = $_REQUEST["equ_number"];
$art_number = $_REQUEST["art_number"];
$art_id = $_REQUEST["art_id"];
$dep_id = $_REQUEST["dep_id"];
$level = $_REQUEST["level"];
?>

<body>
    <!-- <div class="container"> -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">

                    <!-- <h3>coming soon....</h3> -->
                    <div id="zoom-marker-div" class="zoom-marker-div">
                        <img class="zoom-marker-img-dep" id="zoom-marker-img-dep" alt="zoom-marker-img-dep" name="zoom-marker-img-dep" draggable="false">
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <div class="col-md-4">
                    <div id="zoom-marker-div2" class="zoom-marker-div2">
                        <img class="zoom-marker-img-dep2" id="zoom-marker-img-dep2" alt="zoom-marker-img-dep2" name="zoom-marker-img-dep2" draggable="false">
                    </div>
                </div>
                <div class="col-md-4">
                    <div id="zoom-marker-div3" class="zoom-marker-div3">
                        <img class="zoom-marker-img-dep3" id="zoom-marker-img-dep3" alt="zoom-marker-img-dep3" name="zoom-marker-img-dep3" draggable="false">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</body>

</html>
<?php require_once "setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {
        var initImg = function(item) {
            // handle "TAP" event and add marker to image
            item.on("zoom_marker_mouse_click", function(event, position) {
                console.log("Mouse click on: " + JSON.stringify(position));
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
                    url: "ajax/getMap.php",
                    data: {
                        getMapLook: true,
                        people_dep_id: "<?php echo $dep_id; ?>"
                    },
                    success: function(result) {
                        let obj = JSON.parse(result)
                        console.log(obj)
                        obj.forEach(element => {
                            item.zoomMarker_AddMarker({
                                id: element.people_dep_id,
                                src: "img/marker.svg",
                                x: element.map_x,
                                y: element.map_y,
                                size: 40,
                                dialog: {
                                    value: element.people_dep_name,
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

        initImg($('#zoom-marker-img-dep'));
        let level_art
        var initImg2 = function(item) {
            // handle "TAP" event and add marker to image
            item.on("zoom_marker_mouse_click", function(event, position) {
                console.log("Mouse click on: " + JSON.stringify(position));
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
                    url: "ajax/getMap.php",
                    data: {
                        getMapLookArt: true,
                        art_id: "<?php echo $art_id; ?>"
                    },
                    success: function(result) {
                        let obj = JSON.parse(result)
                        console.log(obj)
                        obj.forEach(element => {
                            level_art = element.level
                            item.zoomMarker_AddMarker({
                                id: element.art_id,
                                src: "img/marker.svg",
                                x: element.art_x,
                                y: element.art_y,
                                size: 40,
                                dialog: {
                                    value: element.art_number + " " + element.nameArt,
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

        initImg2($('#zoom-marker-img-dep2'));

        var initImg3 = function(item) {
            // handle "TAP" event and add marker to image
            item.on("zoom_marker_mouse_click", function(event, position) {
                console.log("Mouse click on: " + JSON.stringify(position));
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
                    url: "ajax/getMap.php",
                    data: {
                        getMapLookEqu: true,
                        art_number: "<?php echo $art_number; ?>",
                        equ_number: "<?php echo $equ_number; ?>"
                    },
                    success: function(result) {
                        let obj = JSON.parse(result)
                        console.log(obj)
                        obj.forEach(element => {
                            level_art = element.level
                            item.zoomMarker_AddMarker({
                                id: element.equ_number,
                                src: "img/marker.svg",
                                x: element.equ_x,
                                y: element.equ_y,
                                size: 40,
                                dialog: {
                                    value: element.equ_number + " " + element.equ_name,
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

        initImg3($('#zoom-marker-img-dep3'));


        /******************** INIT ZoomMarker here *****************************/
        $('#zoom-marker-img-dep').zoomMarker({
            src: "img/0002.jpg",
            rate: 0.2,
            width: "50%",
            height: "50%",
            max: "100%",
            markers: [
                //{src:"../img/marker.svg", x:300, y:300}
            ]
        });
        $('#zoom-marker-img-dep2').zoomMarker({
            src: "pic_buildings/" + "<?php echo $dep_id . "_" . $level; ?>" + ".jpg",
            rate: 0.2,
            width: "100%",
            height: "100%",
            max: "100%",
            markers: [
                //{src:"../img/marker.svg", x:300, y:300}
            ]
        });

        $('#zoom-marker-img-dep3').zoomMarker({
            src: "pic_rooms/" + "<?php echo $art_number . "_" . $dep_id; ?>" + ".jpg",
            rate: 0.2,
            width: "100%",
            height: "100%",
            max: "100%",
            markers: [
                //{src:"../img/marker.svg", x:300, y:300}
            ]
        });


    })
</script>