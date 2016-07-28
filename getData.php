<?php
if(isset($_POST['page'])){
    //Include pagination class file
    include('/Pagination.php');
    
    //Include database configuration file
    include('/dbConfig.php');
    
    $start = !empty($_POST['page'])?$_POST['page']:0;
    $limit = 50;
    

    //get number of rows
    $queryNum = $db->query("SELECT COUNT(*) as postNum FROM registro");
    $resultNum = $queryNum->fetch_assoc();
    $rowCount = $resultNum['postNum'];
    
    //initialize pagination class
    $pagConfig = array('baseURL'=>'/wp-content/themes/vive/getData.php', 'totalRows'=>$rowCount, 'currentPage'=>$start, 'perPage'=>$limit, 'contentDiv'=>'posts_content');
    $pagination =  new Pagination($pagConfig);
    
    //get rows
    $query = $db->query("SELECT * FROM registro ORDER BY id DESC LIMIT $start,$limit");
    
    if($query->num_rows > 0){ ?>
        <?php echo $pagination->createLinks(); ?>
        <div class="pager-list margintop10 marginbot10"></div>
            <div class="inventario margintop25">
            <div class="col-md-2 col-sm-2 col-xs-4"><h4>Fecha</h4></div>
            <div class="col-md-2 col-sm-2 col-xs-4"><h4>Cliente</h4></div>
            <div class="col-md-2 col-sm-2 col-xs-4"><h4>Banco</h4></div>
            <div class="col-md-2 col-sm-2 col-xs-4"><h4>Número de Referencia</h4></div>
            <div class="col-md-2 col-sm-2 col-xs-4"><h4>Monto</h4></div>
            <div class="col-md-2 col-sm-2 col-xs-4"><h4>Status</h4></div>
        </div>
        <div class="clearfix"></div>
        <div class="posts_list">
        <?php
            while($row = $query->fetch_assoc()){ 
                $postID = $row['id'];
                $iddeposito=$row['id'];
                $clientedeposito=$row['cliente'];
                $fechadeposito=$row['fecha'];
                $bancodeposito=$row['banco'];
                $referenciadeposito=$row['referencia'];
                $montodeposito=$row['monto'];
                $statusdeposito=$row['status'];
                if ($statusdeposito=='aprobado') {
                    $fondo="btn-success";
                } elseif ($statusdeposito=='pendiente') {
                    $fondo="btn-warning";
                }elseif ($statusdeposito=='negada') {
                    $fondo="btn-danger";
                }
                $fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fechadeposito);
                $fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
                $fechaunixdep=strtotime($fechacambiadadep);
            ?>
            <div class="<?php echo $clientedeposito; ?> <?php echo $bancodeposito; ?> <?php echo $statusdeposito; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
                <form name="importa<?php echo $iddeposito; ?>" method="post" action="http://vivecolecciones.com.ve/cuentas-clientes/" >
                    <div class="row text-center bordertopnegro">
                        <div class="col-md-2 col-sm-2 col-xs-12"> 
                            <input placeholder="Fecha"  id="fecha<?php echo $iddeposito; ?>" name="fecha<?php echo $iddeposito; ?>" type="text" class="form-control" value="<?php echo $fechadeposito; ?>">
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
                            <?php echo $clientedeposito; ?>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
                            <?php echo $bancodeposito; ?>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12 paddingtop10"> 
                            <?php echo $referenciadeposito; ?>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12 paddingtop10">
                            Bsf <?php echo number_format($montodeposito, 2, ',', '.'); ?>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12 <?php echo $fondo; ?>">
                            <h6><?php echo $statusdeposito; ?></h6>
                        </div>
                    </div>
                    <div class="row text-center marginbot10 paddingbot10 borderbotnegro">
                            <input class="btn btn-success btnedc" type="submit" name="btn" id="btn"  value="Aprobar" />
                        
                            <input class="btn btn-warning btnedc" type="submit" name="btn" id="btn"  value="Pendiente" />
                        
                            <input class="btn btn-danger btnedc" type="submit" name="btn" id="btn"  value="Negar" />
                        
                            <input class="btn btn-primary btnedc" type="submit" name="btn" id="btn"  value="Editar" />
                        
                            <input class="btn btn-default btnedc" type="submit" name="btn" id="btn"  value="Eliminar" />
                        
                    </div>
                    <input hidden type="text" name="id" id="id" value="<?php echo $iddeposito; ?>">
                </form>
            </div>
            <script>
              jQuery(function() {
                jQuery( "#fecha<?php echo $iddeposito; ?>" ).datepicker({
                    dateFormat: 'dd/mm/yy',
                    defaultDate: '<?php echo $fechadeposito; ?>'
                });
              });
            </script>
            <div class="clearfix"></div>
        <?php } ?>
        </div>
        <?php echo $pagination->createLinks(); ?>
<?php }
}
?>