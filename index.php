<?php
  include 'includes/conexion.php';
  include 'includes/header.php';

  $publicaciones = $conexion->query("SELECT pu.id, pu.titulo, pu.capacidad, pu.descripcion, pu.fecha, ci.nombre as ciudad, pr.nombre as provincia, pu.ciudad_id, ca.nombre as categoria, u.premium
FROM publicacion pu
INNER JOIN categoria ca ON ca.id = pu.categoria_id
INNER JOIN usuario u ON u.id = pu.usuario_id
INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
INNER JOIN provincia pr ON pr.id = ci.provincia_id
WHERE ca.activa");

  $plazas = $conexion->query("SELECT capacidad FROM publicacion GROUP BY capacidad");

?>

  <div class="navbar navbar-default navbar-static-top search-bar" id="search-bar">
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Categoría</label>
            <select name="categoria" class="form-control">
              <option value="0">Indistinto</option>
            <?php while ( $categoria = $categorias->fetch_assoc() ){ ?>
              <option value="<?php echo $categoria['id']?>">
                <?php echo $categoria['nombre']?>
              </option>
            <?php } ?>
            </select>
          </div>
        </div>
        <div class="input-daterange">
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label">Fecha entrada</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" class="form-control" placeholder="Entrada" id="datein" name="datein">
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label">Fecha salida</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" class="form-control" placeholder="Salida" id="dateout" name="dateout">
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Cantidad de personas</label>
            <select name="plazas" class="form-control">
              <option value="0">Indistinto</option>
            <?php while ( $plaza = $plazas->fetch_assoc() ){ ?>
              <option value="<?php echo $plaza['capacidad']?>">
                <?php echo $plaza['capacidad']?> Persona<?php echo($plaza['capacidad']!=1)?'s':'';?>
              </option>
            <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="container main">
    <div class="masonry">
    <?php while( $publicacion = $publicaciones->fetch_assoc() ){ ?>
      <?php include 'includes/publicacion.php'; ?>
    <?php } ?>
    </div> 
  </div>
<?php include 'includes/footer.php'; ?>