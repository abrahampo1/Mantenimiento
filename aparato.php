
<?php
include('database.php');
if(!isset($_GET['a']))
{
    header('Location: error.php?e=0');
}else
{
    $aparato = $_GET['a'];
}
function buscarbdo($sql)
{
    include('database.php');
    if(!$result = mysqli_query($link, $sql)){
        echo mysqli_error($link);
        header('Location: error.php?e=1');
    }
    return $result;
}
$sql = "SELECT * FROM ordenadores WHERE id = $aparato";
$bdo = buscarbdo($sql);
$info = mysqli_fetch_assoc($bdo);
if(!isset($info['nombre']))
{
    header('Location: error.php?e=0'); 
}
if(isset($_GET['sendping']))
{
    $estado = 'Fallo 288';
    exec('ping -c2 -w2 -q '.$info['ip'],$pingout);
    $pong = explode(',', $pingout[2]);
    $pongpor = explode('%', $pong[2]);
    if($pongpor[0]=='0')
    {
        $estado = 'Conectado';
    }else
    {
        $estado = 'Desconectado';
    }
    $ahora = time();
    $sql = "UPDATE `ordenadores` SET `last_status` = '$estado', `status_date` = '$ahora' WHERE `ordenadores`.`id` = $aparato";
    if(!mysqli_query($link, $sql)){
        echo mysqli_error($link);
        header('Location: error.php?e=1');
    }else{
        header('Location: aparato.php?a='.$aparato);
    }
    print($estado);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Aparato</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
            <br>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?echo $info['nombre']?></h1>
                        <div>
                        <a href="?a=<?echo $aparato?>&sendping=1" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-paper-plane fa-sm text-white-50"></i> Enviar Ping</a>
                        <a href="?a=<?echo $aparato?>&edit=1" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                        class="fas fa-pen-square fa-sm text-white-50"></i> Editar</a>
                        </div>
                        
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Fecha de Actualizacion</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?echo date('r' , $info['status_date'])?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Estado del ping</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?echo $info['last_status']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-table-tennis fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                        
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">IP
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                <?
                                        if(isset($_GET["edit"]))
                                        {
                                            echo'<form method="post" action="aparato.php?a='.$info["id"].'"><input name="ip" type="text" class="form-control form-control-user h5 mb-0 mr-3 font-weight-bold text-gray-800" value="'.$info['ip'].'"><br><button class="btn btn-primary btn-user btn-block" type="submit">Guardar</button></form>';
                                        }else
                                        {
                                            echo '<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">'.$info['ip'].'</div>';
                                        }
                                        ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-network-wired fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Ubicación</div>
                                                <?
                                        if(isset($_GET["edit"]))
                                        {
                                            echo'<form method="post" action="aparato.php?a='.$info["id"].'><input name="ubicacion" type="text" class="form-control form-control-user h5 mb-0 mr-3 font-weight-bold text-gray-800" value="'.$info['ubicacion'].'"><br><button class="btn btn-primary btn-user btn-block" type="submit">Guardar</button></form>';
                                        }else
                                        {
                                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$info['ubicacion'].'</div>';
                                        }
                                        ?>
                                            
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-map-marked fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-7">
                        <div class="row">
                        <?
                        if($info['tipo'] == 'ordenador' || $info['tipo'] == 'servidor')
                        {
                            echo(
                                '<div class="col-lg-4 mb-3">
                                <div class="card bg-primary text-white shadow">
                                    <div class="card-body">
                                        CPU
                                        <div class="text-white-50 small">'.$info['cpu'].'</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="card bg-success text-white shadow">
                                    <div class="card-body">
                                        RAM
                                        <div class="text-white-50 small">'.$info['ram'].'</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="card bg-info text-white shadow">
                                    <div class="card-body">
                                        DISCO DURO
                                        <div class="text-white-50 small">'.$info['disco'].'</div>
                                    </div>
                                </div>
                            </div>'
                            );
                        }
                        ?>
                                
                            </div>

                        </div>

                        <!-- Pie Chart -->
                        
                    </div>
                    <!-- Pending error tickets calculator -->
                    <h2>Tickets de mantenimiento</h2>
                    <?
                    $sql = "SELECT * FROM ticket WHERE aparato=$aparato";
                    $do = buscarbdo($sql);
                    $tickets = 0;
                    while($row = mysqli_fetch_assoc($do))
                    {
                        $tickets++;
                    }
                    if($tickets == 0)
                        {
                            echo ('<div style="text-align:center">
                            <h4 style="text-align:center">Todo está en orden.</h4>
                            </div>');
                        }
                    ?>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            

                            <!-- Color System -->
                            <div class="row">
                            <?
                        $sql = "SELECT * FROM ticket WHERE aparato=$aparato";
                        $do = buscarbdo($sql);
                        while($row = mysqli_fetch_assoc($do))
                        {
                            echo('<a style="text-decoration:none;" href="ticket.php?t='.$row['id'].'"><div class="col-lg-4 mb-4">
                            <div class="card bg-danger text-white shadow">
                                <div class="card-body">
                                    '.$row['tipo_error'].'
                                    <div class="text-white-50 small">'.$row['descripcion'].'</div>
                                </div>
                            </div></a>
                        </div>');
                        }
                        
                        ?>
                                
                                
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CPSoftware 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    

</body>

</html>