<?php
session_start();
unset($_SESSION['cart']);
header("Location: pembelian.php");
exit();
?>
