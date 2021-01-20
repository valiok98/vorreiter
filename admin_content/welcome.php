<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../definitions.php';
require_once dirname(__FILE__) . '/sockets/order_socket.php';

session_start();

$title = '';

if (isset($_SESSION['username'])) {
    $title = 'Welcome, ' . $_SESSION['username'] . '!';
    $username = $_SESSION['username'];
} else {
    header('location: ' . URL . 'index_content/logout.php');
    die;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Moment.js start -->
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <!-- Moment.js end -->

    <!-- HTML2PDF start -->
    <script src="js/html2pdf.bundle.min.js"></script>
    <!-- HTML2PDF end -->

    <!-- Eigenes CSS start -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Eigenes CSS end -->

    <!-- Eigenes JS start -->
    <script>
        var mainUrl = '<?= URL ?>';
        var domain = '<?= $_SERVER['HTTP_HOST'] ?>';
        var username = '<?= $_SESSION['username'] ?>';
    </script>
    <script src="../dist/admin.js" defer></script>
    <!-- <script src="js/order_socket.js" defer></script> -->
    <!-- Eigenes JS end -->
</head>

<body>
    <div id="admin">
        <admin_content></admin_content>
        <!-- toast component. -->
        <toast></toast>
    </div>
</body>

</html>
<?php
$mysqli->close();
?>