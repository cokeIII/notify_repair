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
?>
<!-- Bootstrap core JavaScript-->
<script src="<?php echo $url.'/vendor/jquery/jquery.min.js';?>"></script>
<script src="<?php echo $url.'/vendor/bootstrap/js/bootstrap.bundle.min.js';?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo $url.'/vendor/jquery-easing/jquery.easing.min.js';?>"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo $url.'/js/sb-admin-2.min.js';?>"></script>

<!-- Page level plugins -->
<script src="http://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>