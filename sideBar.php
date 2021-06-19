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
            <a class="nav-link" href="<?php echo $url . '/repair/repair.php'; ?>">
                <i class="fas fa-wrench"></i>
                <span>แจ้งซ่อม</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $url . '/manageMap/map.php'; ?>">
            <i class="fas fa-map-marked-alt"></i>
                <span>จัดการแผนที่</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $url . '/manageRoom/room.php'; ?>">
            <i class="fas fa-door-open"></i>
                <span>จัดการห้องเรียน</span></a>
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