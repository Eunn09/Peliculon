<?php
session_start();
if(!isset($_SESSION["admin"])){
    
    header("Location:inicio de sesion.php");
}else{

 include 'connection.php';

 $sql = "SELECT i.exist_inv, p.tit_peli, s.nom_suc 
         FROM inventario i
         INNER JOIN pelicula p ON i.id_peli = p.id_peli
         INNER JOIN sucursal s ON i.id_suc = s.id_suc";
 $query = mysqli_query($conexion, $sql);

 

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> INVENTARIO </title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #C40006;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"> GESTION <sup> INVENTARIO </sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Gestiones 
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="gestcli.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Clientes</span></a>
            </li>

             <!-- Divider -->
             <hr class="sidebar-divider my-0">


             <!-- Nav Item - Tables -->
             <li class="nav-item">
                <a class="nav-link" href="gestpeli.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Peliculas</span></a>
            </li>

             <!-- Divider -->
             <hr class="sidebar-divider my-0">

             <!-- Nav Item - Tables -->
             <li class="nav-item">
                <a class="nav-link" href="gestusu.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Usuarios</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Heading -->
            <div class="sidebar-heading">
                INVENTARIO Y SUCURSALES
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="gestinv.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>INVENTARIO</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="gestsuc.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>SUCURSALES</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="gestact.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>ACTOR</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reportes.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>REPORTES</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Cerrar sesion</span></a>
            </li>
              <!-- Divider -->
              <hr class="sidebar-divider d-none d-md-block">
        </ul>
                 
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="dashboard.php" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#597e8d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                  </svg>
                            </a>
                             <!-- Dropdown - User Information -->
                             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                             <div class="dropdown-divider"></div>
                             <a class="dropdown-item" href="dashboard.html">
                                 <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                 Regresar a inicio
                             </a>
                             <div class="dropdown-divider"></div>
                             <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                 <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                 Salir
                             </a>
                         </div>
                        </li>

                    </ul>

                </nav>


                <!-- End of Topbar -->
                <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary text-danger"> Gestion de Peliculas </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <a href="Reporte_Stock.php" class="btn btn-primary" style="background-color: #C40006;">Generar reporte</a>
                                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Existencias</th>
                                            <th>Pelicula</th>
                                            <th>Sucursal</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <?php
                                            while($row=mysqli_fetch_array($query)):?>
                                            <td><?=$row['exist_inv']?></td>
                                            <td><?=$row['tit_peli']?></td>
                                            <td><?=$row['nom_suc']?></td>
                                            
                                        </tr>
                                        <?php endwhile?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body d-flex justify-content-center">
                                <a href="agregar inventario.php" class="btn btn-primary" style="background-color: #C40006;">Agregar inventario</a>
                                <!-- Resto del código de la tabla -->
                              </div>
                        </div>
                    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Peliculon 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   <!-- Logout Modal-->
   <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">¿Segurx que deseas salir?</h5>
               <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">×</span>
               </button>
           </div>
           <div class="modal-body">Al seleccionar salir te redirigiremos al inicio de sesion</div>
           <div class="modal-footer">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
               <a class="btn btn-primary" href="login.php">Salir</a>
           </div>
       </div>
   </div>
</div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>
<?php
}

?>
</html>