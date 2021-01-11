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
    <!-- Bootstrap start -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- Bootstrap end -->

    <!-- Data tables start -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <!-- Data tables end -->

    <!-- Editable start -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <!-- Editable end -->
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
        <div class="container-fluid">
            <div class="row">
                <!-- sidenav component. -->
                <sidenav></sidenav>
                <div id="div_main_content" class="col-sm-11">
                    <!-- mainnav component. -->
                    <mainnav></mainnav>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab_clients" data-tabs="tabs">
                            <create_client_button></create_client_button>
                            <client_table></client_table>
                        </div>
                        <div class="tab-pane active container-fluid" id="tab_vorreiter" data-tabs="tabs">
                            <div class="row">
                                <div class="col-lg-6 container-fluid">
                                    <div class="row div_table_header">
                                        <h3>Anfragen</h3>
                                        <div>
                                            <inquiry_theader></inquiry_theader>
                                        </div>
                                    </div>

                                    <div class="row div_inq_ord_table_data">
                                        <inquiry_table></inquiry_table>
                                    </div>
                                </div>
                                <div class="col-lg-6 container-fluid">
                                    <div class="row div_table_header">
                                        <h3>Aufträge</h3>
                                        <div>
                                            <order_theader></order_theader>
                                        </div>
                                    </div>
                                    <div class="row div_inq_ord_table_data">
                                        <order_table></order_table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane table-responsive" id="tab_inq_ord_data" data-tabs="tabs">
                            <inquiry_order_theader></inquiry_order_theader>
                            <div class="tab-content">
                                <div id="div_inquiries" class="tab-pane active">
                                    <inquiry_table v-if="this.$store.state.inquiries.length"></inquiry_table>
                                </div>
                                <div id="div_orders" class="tab-pane">
                                    <order_table v-if="this.$store.state.orders.length"></order_table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_settings" data-tabs="tabs">
                            <!-- settings component. -->
                            <settings></settings>
                        </div>
                        <div class="tab-pane" id="tab_tracking" data-tabs="tabs">
                            <h1>Tracking</h1>
                        </div>
                        <div class="tab-pane" id="tab_fleet" data-tabs="tabs">
                            <h1>Flotte</h1>
                        </div>
                        <div class="tab-pane" id="tab_support" data-tabs="tabs">
                            <h1>Support</h1>
                        </div>
                        <div class="tab-pane" id="tab_stats" data-tabs="tabs">
                            <h1>Stats</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- toast component. -->
        <toast></toast>
    </div>

</body>

</html>
<?php
$mysqli->close();
?>