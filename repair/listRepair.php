<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "../setHead.php"; ?>
    <?php
    require_once "../connect.php";
    if (empty($_SESSION["people_id"])) {
        header("location: ../index.php");
    }
    $people_id = $_SESSION["people_id"];
    if (!empty($_REQUEST["rep_id"])) {
        $rep_id = $_REQUEST["rep_id"];
        $sql = "select * from repair rep, equipment equ where rep.equ_number = equ.equ_number and rep.rep_id = '$rep_id'";
    } else {
        if ($_SESSION["people_status"] == "staff") {
            $sql = "select * from repair rep, equipment equ where rep.equ_number = equ.equ_number";
        } else if ($_SESSION["people_status"] == "user") {
            $sql = "select * from repair rep, equipment equ where rep.equ_number = equ.equ_number and people_id = '$people_id'";
        } else {
            $sql = "";
        }
    }
    $result = mysqli_query($conn, $sql);
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
                    <div class="card">
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <table class="table" id="listRepair">
                                        <thead>
                                            <tr>
                                                <th>หมายเลขอุปกรณ์</th>
                                                <th>ชื่ออุปกรณ์</th>
                                                <!-- <th>รายระเอียดที่แจ้ง</th> -->
                                                <th>สถานะ</th>
                                                <th>วันที่</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><a href="#" class="showDetail" rep_id="<?php echo $row['rep_id']; ?>"><?php echo $row["equ_number"]; ?></a></td>
                                                        <td><?php echo $row["equ_name"]; ?></td>
                                                        <!-- <td><?php //echo $row["rep_description"]; 
                                                                    ?></td> -->
                                                        <td><?php echo $row["rep_status"]; ?></td>
                                                        <td><?php echo $row["rep_time"]; ?></td>
                                                        <?php if ($_SESSION["people_status"] == "staff") {
                                                            if ($row["rep_status"] == "รายการส่งซ่อม") { ?>
                                                                <td><button class="btn btn-info acceptRepair" equ_number="<?php echo $row["equ_number"]; ?>" rep_id="<?php echo $row["rep_id"]; ?>"><i class="fas fa-vote-yea"></i> ยอมรับ</button></td>
                                                                <td><button class="btn btn-danger cancelRepair" equ_number="<?php echo $row["equ_number"]; ?>" rep_id="<?php echo $row["rep_id"]; ?>"><i class="fas fa-window-close"></i> ยกเลิก</button></td>
                                                            <?php } else if ($row["rep_status"] == "ยกเลิกรายการ") { ?>
                                                                <td><button class="btn btn-info acceptRepair" equ_number="<?php echo $row["equ_number"]; ?>" rep_id="<?php echo $row["rep_id"]; ?>"><i class="fas fa-vote-yea"></i> ยอมรับ</button></td>
                                                                <td><button class="btn btn-danger deleteRepair" rep_id="<?php echo $row["rep_id"]; ?>"><i class="fas fa-minus-circle"></i> ลบ</button></td>
                                                            <?php } else if ($row["rep_status"] == "กำลังดำเนินการซ่อม") { ?>
                                                                <td><button class="btn btn-success successRepair" equ_number="<?php echo $row["equ_number"]; ?>" rep_id="<?php echo $row["rep_id"]; ?>"><i class="fas fa-check-circle"></i> สำเร็จ</button></td>
                                                                <td><button class="btn btn-danger cancelRepair" equ_number="<?php echo $row["equ_number"]; ?>" rep_id="<?php echo $row["rep_id"]; ?>"><i class="fas fa-window-close"></i> ยกเลิก</button></td>
                                                            <?php } else if ($row["rep_status"] == "สำเร็จ") { ?>
                                                                <td><button class="btn btn-danger cancelRepair" equ_number="<?php echo $row["equ_number"]; ?>" rep_id="<?php echo $row["rep_id"]; ?>"><i class="fas fa-window-close"></i> ยกเลิก</button></td>
                                                                <td><button class="btn btn-danger deleteRepair" equ_number="<?php echo $row["equ_number"]; ?>" rep_id="<?php echo $row["rep_id"]; ?>"><i class="fas fa-minus-circle"></i> ลบ</button></td>
                                                            <?php } else { ?>
                                                                <td></td>
                                                                <td></td>
                                                            <?php }
                                                        } else { ?>
                                                            <?php if ($_SESSION["people_status"] == "user") {
                                                                if ($row["rep_status"] == "รายการส่งซ่อม") { ?>
                                                                    <td><button class="btn btn-danger cancelRepair" equ_number="<?php echo $row["equ_number"]; ?>" rep_id="<?php echo $row["rep_id"]; ?>"><i class="fas fa-window-close"></i> ยกเลิก</button></td>
                                                                    <td></td>
                                                                <?php } else { ?>
                                                                    <td></td>
                                                                    <td></td>
                                                        <?php }
                                                            }
                                                        } ?>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>ชื่ออุปกรณ์</th>
                                                <th>สถานะ</th>
                                                <th>วันที่</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
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
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>

<!-- Modal -->
<div class="modal fade layer-9999 bd-example-modal-lg" id="detailEqu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รายละเอียด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>หมายเลขอุปกรณ์</label>
                                        <input type="text" name="equ_number" id="equ_number" required class="form-control" placeholder="0140-001-0007/302-09" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>ชื่ออุปกรณ์</label>
                                        <input type="text" name="equ_name" id="equ_name" required class="form-control" placeholder="Notebook acer" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>รายละเอียด</label>
                                        <textarea name="equ_description" id="equ_description" cols="30" rows="5" class="form-control" required readonly></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 border-left">
                                    <div class="form-group">
                                        <label>รายละเอียดความเสียหาย</label>
                                        <textarea name="rep_description" id="rep_description" cols="30" rows="5" class="form-control" required readonly></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div id="equAddress">

                                        </div>
                                    </div>
                                    <button class="btn btn-info mt-3" id="lookMap">ดูแผนที่</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php require_once "../setFoot.php"; ?>

</html>
<script>
    $(document).ready(function() {
        let equ_number
        let art_number
        let dep_id
        let art_id
        let level
        $(".showDetail").click(function() {
            $.ajax({
                type: "POST",
                url: "../ajax/getDetailRep.php",
                data: {
                    rep_id: $(this).attr("rep_id"),
                },
                success: function(result) {
                    let obj = JSON.parse(result)
                    equ_number = obj.equ_number
                    art_number = obj.art_number
                    dep_id = obj.dep_id
                    art_id = obj.art_id
                    level = obj.level
                    $("#equ_number").val(obj.equ_number)
                    $("#equ_name").val(obj.equ_name)
                    $("#equ_description").val(obj.equ_description)
                    $("#rep_description").val(obj.rep_description)
                    $("#equAddress").html(obj.people_dep_name + " -> " + obj.art_number_name)
                    $("#detailEqu").modal("show")
                }
            });
        })
        $("#listRepair").DataTable({
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    console.log(column)
                    if (column.selector.cols != 0) {
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
            },
            fixedColumns: true
        })
        $(".cancelRepair").click(function() {
            let equ_number = $(this).attr("equ_number")
            let rep_id = $(this).attr("rep_id")
            $.confirm({
                title: 'Cancel',
                content: 'คุณต้องการยกเลิกรายการ ?',
                buttons: {
                    confirm: function() {
                        $.redirect("../ajax/sqlRepair.php", {
                            equ_number: equ_number,
                            rep_id: rep_id,
                            cancel: true
                        });
                    },
                    cancel: function() {},
                }
            });
        })
        $("#lookMap").click(function() {
            $.redirect("../lookMap.php", {
                equ_number: equ_number,
                art_number: art_number,
                dep_id: dep_id,
                art_id: art_id,
                level: level
            }, "POST", "_blank");
        })
        $(".acceptRepair").click(function() {
            let equ_number = $(this).attr("equ_number")
            let rep_id = $(this).attr("rep_id")
            $.confirm({
                title: 'Accept',
                content: 'คุณต้องการยอมรับรายการ ?',
                buttons: {
                    confirm: function() {
                        $.redirect("../ajax/sqlRepair.php", {
                            equ_number: equ_number,
                            rep_id: rep_id,
                            accept: true
                        });
                    },
                    cancel: function() {

                    },
                }
            });
        })
        $(".deleteRepair").click(function() {
            let rep_id = $(this).attr("rep_id")
            let equ_number = $(this).attr("equ_number")
            $.confirm({
                title: 'Delete',
                content: 'คุณต้องการลบรายการ ?',
                buttons: {
                    confirm: function() {
                        $.redirect("../ajax/sqlRepair.php", {
                            equ_number: equ_number,
                            rep_id: rep_id,
                            delete: true
                        });
                    },
                    cancel: function() {

                    },
                }
            });
        })
        $(".successRepair").click(function() {
            let equ_number = $(this).attr("equ_number")
            let rep_id = $(this).attr("rep_id")
            $.confirm({
                title: 'Success',
                content: 'คุณซ่อมสำเร็จแล้ว ?',
                buttons: {
                    confirm: function() {
                        $.redirect("../ajax/sqlRepair.php", {
                            rep_id: rep_id,
                            equ_number: equ_number,
                            success: true
                        });
                    },
                    cancel: function() {

                    },
                }
            });

        })
    })
</script>