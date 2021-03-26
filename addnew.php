<?php

	error_reporting( ~E_NOTICE ); // Notificacion de error
	session_start();
	require_once 'dbconfig.php';
	
	if(isset($_POST['btnsave']))
	{
		$doctype = $_POST['doc_type'];
		
		$imgFile = $_FILES['user_file']['name'];
		$tmp_dir = $_FILES['user_file']['tmp_name'];
		$imgSize = $_FILES['user_file']['size'];
		date_default_timezone_set("America/New_York");
		$docdate = date("Y-m-d H:i:s");
		
		if(empty($doctype)){
			$errMSG = "Por favor selecione el departamento.";
		}
		else if(empty($imgFile)){
			$errMSG = "Por favor selecciona el archivo.";
		}
		else
		{
			$upload_dir = 'user_files/'; // subes al directorio
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // Tener el archivo de la extensión
		
			// validar extensión del archivo
			$valid_extensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc' , 'pdf', 'docx'); // valid extensions
		
			$docfile = $imgFile;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '15MB'
				if($imgSize < 15000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$docfile);
				}
				else{
					$errMSG = "Lo sentimos el tamaño del archivo subera los 5MB.";
				}
			}
			else{
				$errMSG = "Lo sentimos solamente validos: jpg, gif, png, zip, txt, doc, pdf, docx.";		
			}
		}
		
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO tbl_docs(docType, docFile, docDate) VALUES(:dtype, :dfile, :ddate)');
			$stmt->bindParam(':dtype',$doctype);
			$stmt->bindParam(':dfile',$docfile);
			$stmt->bindParam(':ddate',$docdate);
			
			if($stmt->execute())
			{
				$successMSG = "Archivo subida exitosamente";
				header("refresh:3;users.php"); // redirects image view page after 5 seconds.
			}
			else
			{
				$errMSG = "Error durante la subida de archivo";
			}
		}
	}

	require_once 'views/header.php';
?>

<div class="container">

<div class="row">
<div class="col-md-6 col-md-offset-3">

	<div class="page-header">
    	<h1 class="h2"> Subida de Archivo <a class="btn btn-default" href="users.php"> <span class="glyphicon glyphicon-eye-open"></span> Regresar a la página principal </a></h1>
    </div>

	<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>   

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	    
	<table class="table table-responsive">
	
    <tr>
    	<td><label class="control-label"> Departamento </label></td>
        <td>
			<select class="form-control" name="doc_type">
				<option value="<?php echo $_SESSION['rol'] ?>"> <?php echo $_SESSION['rol'] ?> </option>
				<!--  <option value="Contabilidad"> Contabilidad </option>
				<option value="Investigación"> Investigación </option> -->
			</select>
		</td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Nombre del Documento </label></td>
        <td><input class="input-group" type="file" name="user_file" id="user_file" accept="*"/></td>
    </tr>
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Subir Archivo
        </button>
        </td>
    </tr>
    
    </table>
    
</form>
</div>
</div>


<?php
require_once 'views/footer.php';
?>