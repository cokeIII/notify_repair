<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "../setHead.php"; ?>
    <?php
    if (empty($_SESSION["people_id"])) {
        header("location: ../index.php");
    }
    require_once "../connect.php";
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
                <?php
                $sqlListEqu = "select 
                        equ.equ_number,
                        equ.equ_name,
                        equ.equ_description,
                        peo.people_dep_name,
                        art.dep_id,
                        art.art_number,
                        equ_status,
                        concat(art.art_number,' ',art.art_name) as art_number_name
                        from equipment equ,people_dep peo,articles art
                        where  
                        equ.art_number = art.art_number and
                        art.dep_id = peo.people_dep_id";
                $resListEqu = mysqli_query($conn, $sqlListEqu);
                ?>
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <table id="listEquipment">
                                <thead>
                                    <th>หมายเลขอุปกรณ์</th>
                                    <th>ชื่ออุปกรณ์</th>
                                    <th>เลขห้อง</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    while ($rowListEqu = mysqli_fetch_array($resListEqu)) {
                                        $listStatus = "";
                                        if ($rowListEqu["equ_status"] == "รายการส่งซ่อม") {
                                            $listStatus = "text-warning";
                                        } else if ($rowListEqu["equ_status"] == "ยกเลิกรายการ" || $rowListEqu["equ_status"] == "ใช้งานไม่ได้") {
                                            $listStatus = "text-danger";
                                        } else if ($rowListEqu["equ_status"] == "กำลังดำเนินการซ่อม") {
                                            $listStatus = "text-secondary";
                                        } else if ($rowListEqu["equ_status"] == "สำเร็จ" || $rowListEqu["equ_status"] == "ปกติ") {
                                            $listStatus = "text-success";
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $rowListEqu["equ_number"]; ?></td>
                                            <td><?php echo $rowListEqu["equ_name"]; ?></td>
                                            <td><?php echo $rowListEqu["art_number"]; ?></td>
                                            <td class="<?php echo $listStatus; ?>"><?php echo $rowListEqu["equ_status"]; ?></td>
                                            <?php if ($rowListEqu["equ_status"] == "ปกติ" || $rowListEqu["equ_status"] == "ใช้งานไม่ได้") { ?>
                                                <td><button class="btn btn-primary" id="rep" equ_number="<?php echo $rowListEqu["equ_number"]; ?>">แจ้งซ่อม</button></td>
                                            <?php } else { ?>
                                                <td></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>เลขห้อง</th>
                                        <th>สถานะ</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                            <label>หมายเลข</label>
                            <input type="text" name="equ_number" class="form-control" id="equ_number" readonly>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-7">
                                    <label>ชื่อ</label>
                                    <input type="text" name="equ_name" class="form-control" id="equ_name" readonly>
                                </div>
                                <div class="col-md-5">
                                    <label>สถานะ</label>
                                    <input type="text" name="equ_status" class="form-control" id="equ_status" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>รายละเอียดอุปกรณ์</label>
                            <textarea name="equ_description" id="equ_description" class="form-control" cols="30" rows="5" readonly></textarea>
                        </div>
                        <div class="form-group">
                            <label>รายละเอียดอาการความเสียหาย</label>
                            <textarea name="repair_des" id="repair_des" class="form-control" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendRepair">ส่งข้อมูล</button>
            </div>
        </div>
    </div>
</div>
<?php require_once "../setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {
        $("#rep").click(function() {
            $.ajax({
                type: "POST",
                url: "../ajax/getEquRep.php",
                data: {
                    equ_number: $(this).attr("equ_number"),
                },
                success: function(result) {
                    let obj = JSON.parse(result)
                    obj.forEach(element => {
                        $("#equ_number").val(element.equ_number)
                        $("#equ_name").val(element.equ_name)
                        $("#equ_status").val(element.equ_status)
                        $("#equ_description").val(element.equ_description)
                        $('#repairEqu').modal('show')
                    });
                }
            });
        })
        $("#sendRepair").click(function() {
            $.ajax({
                type: "POST",
                url: "../ajax/sqlRepair.php",
                data: {
                    insert: true,
                    equ_number: $("#equ_number").val(),
                    rep_description: $("#repair_des").val(),
                    equ_status: $("#equ_status").val()
                },
                success: function(result) {
                    if (result == "success") {
                        $('#repairEqu').modal('hide')
                        $.bootstrapGrowl("ส่งรายการเรียบร้อย", // Messages
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
                        $.bootstrapGrowl("ส่งรายการไม่สำเร็จ", // Messages
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
                    }
                }
            });
        })
        $("#listEquipment").DataTable({
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    console.log(column)
                    if (column.selector.cols != 0 && column.selector.cols != 1 && column.selector.cols != 4) {
                        var select = $('<select class="form-control"><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    }
                });
            }
        })
    })
</script>