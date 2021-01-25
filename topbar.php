<?
$user_id = $_SESSION["user_id"];
    $sql = "SELECT * FROM tecnicos WHERE id = $user_id";
    $search = mysqli_query($link, $sql);
    $user_info = mysqli_fetch_assoc($search);

?>
<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<a href="index.php"><i class="fas fa-home"></i></a>

    <!-- Topbar Search -->
    <form method="get"
        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar aparato..." value="<?php if(isset($_GET['b'])){echo $_GET['b'];}?>"
                aria-label="Search" name="b" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search" method="GET" target="_blank" action="">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                            placeholder="Search for..." aria-label="Search"
                            aria-describedby="basic-addon2" name="b" id="b">
                        <div class="input-group-append">
                            <input class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <?
                //Sistema de tickets

                    $sql = "SELECT * FROM ticket WHERE tecnico = $user_id";
                    $conteo_tickets = 0;
                    if($ticket_bd = mysqli_query($link, $sql))
                    {

                        while($ticket = mysqli_fetch_assoc($ticket_bd)){
                            $conteo_tickets++;

                        }
                        if($conteo_tickets == 0)
                        {
                            echo '
                            </a>';
                        }else
                        {
                            echo '<span class="badge badge-danger badge-counter">+'.$conteo_tickets.'</span>
                    </a>';
                        }
                    
                    
                    }else
                    {
                        $conteo_tickets = 0;
                        echo '
                    </a>';
                    }
                    
                ?>
                
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Centro de Alertas
                </h6>
                <?
                if($conteo_tickets > 0)
                {
                    $sql = "SELECT * FROM ticket WHERE tecnico = $user_id";
                    $ticket_bd = mysqli_query($link, $sql);
                    while($ticket = mysqli_fetch_assoc($ticket_bd))
                    {
                        $fecha_creacion = date('Y-m-d H:i:s', $ticket["fecha"]);
                        echo'<a class="dropdown-item d-flex align-items-center" href="ticket.php?t='.$ticket["id"].'">
                        <div class="mr-3">
                            <div class="icon-circle bg-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">'.$fecha_creacion.'</div>
                            <span class="font-weight-bold">'.$ticket["tipo_error"].'</span>
                        </div>
                    </a>';
                    }
                }else
                {
                    echo'<a class="dropdown-item d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                        <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                    <div>
                        <span class="font-weight-bold">Todo en orden</span>
                    </div>
                </a>';  
                }
                ?>
                
                <a class="dropdown-item text-center small text-gray-500" href="#">Todas las alertas</a>
            </div>
        </li>

        <!-- Nav Item - Messages -->
        

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><? echo $user_info["nombre"]?></span>
                <img class="img-profile rounded-circle"
                    src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php" >
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cerrar Sesión
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->