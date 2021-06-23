<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.   
$url .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL   
// $url .= $_SERVER['REQUEST_URI'];
$url .= "/notifyRepair";
$userId = null;
if (!empty($_SESSION["people_id"])) {
    $userId = $_SESSION["people_id"];
}
?>
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-tools"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ระบบแจ้งซ่อม</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo $url . '/index.php'; ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        <!-- head text -->
    </div>
    <?php if (!empty($userId)) { ?>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-wrench"></i>
                <span>แจ้งซ่อม</span>
            </a>
            <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Repair:</h6>
                    <a class="collapse-item" href="<?php echo $url . '/repair/repair.php'; ?>">แผนที่</a>
                    <a class="collapse-item" href="<?php echo $url . '/repair/tableRepair.php'; ?>">ตารางรายการ</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $url . '/repair/listRepair.php'; ?>">
                <i class="fas fa-clipboard-list"></i>
                <span>รายการแจ้งซ่อม</span></a>
        </li>
        <?php if ($_SESSION["people_status"] == "staff") { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>จัดการแผนที่</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">MAP:</h6>
                        <a class="collapse-item" href="<?php echo $url . '/manageMap/map.php'; ?>">แผนที่วิทยาลัย</a>
                        <a class="collapse-item" href="<?php echo $url . '/manageMap/mapBuild.php'; ?>">แผนที่อาคาร</a>
                        <a class="collapse-item" href="<?php echo $url . '/manageMap/mapRoom.php'; ?>">แผนที่ห้อง</a>
                    </div>
                </div>
            </li>
        <?php } else if ($_SESSION["people_status"] == "user") { ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url . '/manageMap/mapRoom.php'; ?>">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>อุปกรณ์ภายในห้อง</span></a>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $url . '/manageRoom/room.php'; ?>">
                <i class="fas fa-door-open"></i>
                <span>จัดการห้องเรียน</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $url . '/manageEquipment/equipment.php'; ?>">
                <i class="fas fa-laptop"></i>
                <span>จัดการอุปกรณ์</span></a>
        </li>
    <?php } ?>


    <?php if (!empty($userId)) { ?>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $url . '/logout.php'; ?>">
                <i class="fas fa-sign-out-alt"></i>
                <span>ออกจากระบบ</span></a>
        </li>
    <?php } else { ?>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $url . '/login.php'; ?>">
                <i class="fas fa-sign-in-alt"></i>
                <span>เข้าสู่ระบบ</span></a>
        </li>
    <?php } ?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>