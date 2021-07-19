<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <?php if (!empty($_SESSION["people_id"])) { ?>

        <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1" id="boxAlert">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-tools"></i>
                    <!-- Counter - Messages -->
                    <span class="badge badge-danger badge-counter" id="badgeCounter"></span>
                </a>
                <!-- Dropdown - Messages -->
                <div class="layer-9999 dropdown-list  dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header ">
                        รายการ
                    </h6>
                    <div id="alertRepair">

                    </div>

                    <a class="dropdown-item text-center small text-gray-500" href="<?php echo $url . '/repair/listRepair.php'; ?>">Read More Messages</a>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["people_Name"] . "(" . $_SESSION["people_status"] . ")"; ?></span>
                </a>
            </li>
        </ul>
    <?php } ?>
</nav>
<!-- End of Topbar -->
<!-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> -->
<Script>
    $(document).ready(function() {
        $(document).on("click", ".alertItem", function() {
            $.redirect("<?php echo $url . '/repair/listRepair.php'; ?>", {
                rep_id: $(this).attr("rep_id")
            }, "POST");
        })
        reAlert()
        $("#boxAlert").click(function() {
            $("#badgeCounter").html("")
            $.ajax({
                type: "POST",
                url: "<?php echo $url . "/ajax/getAlert.php"; ?>",
                data: {
                    read: true,
                },
                success: function(result) {
                    reAlert()
                }
            });
        })
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('05ee423672484752406d', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            console.log(data)
            reAlert()
        });
    })

    function reAlert() {
        $.ajax({
            type: "POST",
            url: "<?php echo $url . "/ajax/getAlert.php"; ?>",
            data: {
                admin: true,
            },
            success: function(result) {
                let obj = JSON.parse(result)
                if (obj.length < 0) {
                    return
                }
                if (obj.count > 0) {
                    $("#badgeCounter").html(obj.count)
                }
                $("#alertRepair").empty();
                $.each(obj.data, function(index, value) {
                    let logoAlert = '';
                    if (value.rep_status == "รายการส่งซ่อม") {
                        logoAlert = '<h3><i class="fas fa-wrench text-warning"></i></h3>'
                    } else if (value.rep_status == "ยกเลิกรายการ") {
                        logoAlert = '<h3><i class="fas fa-calendar-times text-danger"></i></h3>'
                    } else if (value.rep_status == "กำลังดำเนินการซ่อม") {
                        logoAlert = '<h3><i class="fas fa-cogs text-secondary"></i></h3>'
                    } else if (value.rep_status == "สำเร็จ") {
                        logoAlert = '<h3><i class="fas fa-clipboard-check text-success"></i></h3>'
                    }
                    $("#alertRepair").append(
                        '<div class="dropdown-item d-flex align-items-center alertItem"  rep_id="' + value.rep_id + '">' +
                        '<div class="dropdown-list-image mr-3">' +
                        logoAlert +
                        '</div>' +
                        '<div class="font-weight-bold">' +
                        '<div class="text-truncate">' + value.equ_number + " " + value.equ_name + '</div>' +
                        '<div class="small text-gray-500">' + value.rep_time + ' ' + value.rep_status + '</div>' +
                        '</div>' +
                        '</div>')
                });
            }
        });
    }
</Script>