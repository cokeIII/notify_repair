<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "setHead.php"; ?>
</head>
<?php
$equ_number = $_REQUEST["equ_number"];
$art_number = $_REQUEST["art_number"];
$dep_id = $_REQUEST["dep_id"];
?>

<body>
    <!-- <div class="container"> -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="container-fluid">
                        <h3>coming soon....</h3>
                        <!-- <div id="zoom-marker-div" class="zoom-marker-div">
                            <img class="zoom-marker-img-dep" id="zoom-marker-img-dep" alt="zoom-marker-img-dep" name="zoom-marker-img-dep" draggable="false">
                        </div> -->
                        <!-- /.container-fluid -->
                    </div>
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-4">

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
                // $.ajax({
                //     type: "POST",
                //     url: "../ajax/getMap.php",
                //     data: {
                //         getMap: true,
                //     },
                //     success: function(result) {
                //         let obj = JSON.parse(result)
                //         obj.forEach(element => {
                //             item.zoomMarker_AddMarker({
                //                 id: element.people_dep_id,
                //                 src: "../img/marker.svg",
                //                 x: element.map_x,
                //                 y: element.map_y,
                //                 size: 40,
                //                 dialog: {
                //                     value: element.people_dep_name,
                //                     style: {
                //                         color: "black"
                //                     }
                //                 },
                //                 hint: {

                //                 },
                //                 draggable: false
                //             });
                //         });
                //     }
                // });
            });

            // message after at the end of Maker moving action
            item.on("zoom_marker_move_end", function(event, position) {
                console.log(position.markerObj.param.id);
            })
        }

        initImg($('#zoom-marker-img-dep'));

        /******************** INIT ZoomMarker here *****************************/
        $('#zoom-marker-img').zoomMarker({
            src: "../img/0002.jpg",
            rate: 0.2,
            width: "50%",
            height: "50%",
            max: "100%",
            markers: [
                //{src:"../img/marker.svg", x:300, y:300}
            ]
        });
    })
</script>