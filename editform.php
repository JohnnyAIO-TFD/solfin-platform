<?php

	error_reporting( ~E_NOTICE );
	
	require_once 'dbconfig.php';
	
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT docType, docFile, docDate FROM tbl_docs WHERE docID =:did');
		$stmt_edit->execute(array(':did'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
		$docdate = date("Y-m-d H:i:s");
	}
	else
	{
		header("Location: users.php");
	}
	
	
	
	if(isset($_POST['btn_save_updates']))
	{
		$doctype = $_POST['doc_type'];// user name
			
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		date_default_timezone_set("America/New_York");
		$docdate = date("Y-m-d H:i:s");
		if($imgFile)
		{
			$upload_dir = 'user_files/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc' , 'pdf', 'docx'); // valid extensions
			$docfile = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$edit_row['docFile']);
					move_uploaded_file($tmp_dir,$upload_dir.$docfile);
				}
				else
				{
					$errMSG = "Lo sentimos, tu archivo superas los 5MB";
				}
			}
			else
			{
				$errMSG = "Lo sentimos solamente validos: jpg, gif, png, zip, txt, doc, pdf, docx.";		
			}	
		}
		else
		{
			$docfile = $edit_row['docFile']; 
		}	
						
		
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare("UPDATE tbl_docs 
									     SET docType=:dtype, 
										     docFile=:dfile,
										     docDate=:ddate 
								       WHERE docID=:did");
			$stmt->bindParam(':dtype',$doctype);
			$stmt->bindParam(':dfile',$docfile);
			$stmt->bindParam(':dfile',$docdate);
			$stmt->bindParam(':did',$id);
				
			if($stmt->execute()){
				?>
        <script>
				window.location.href='users.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Lo sentimos no se pudo subir el archivo";
			}
		
		}
		
						
	}
	
	require_once 'views/header.php';
?>



<div class="container">

<div class="row">
<div class="col-md-6 col-md-offset-3">

	<div class="page-header">
    	<h1 class="h2">Actualizar Documento / <a class="btn btn-default" href="users.php"> <span class="glyphicon glyphicon-eye-open"></span> Regresar a la página principal </a></h1>
    </div>

<div class="clearfix"></div>
<form method="post" enctype="multipart/form-data" class="form-horizontal">
	
    
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
   
    
	<table class="table table-responsive">
	
    <tr>
    	<td><label class="control-label">Departamento </label></td>
        <td>
			<select class="form-control" name="doc_type" id="selectID">
				<option value="Cumplimiento">Cumplimiento </option>
				<option value="Contaduria"> Contabilidad </option>
				<option value="Publicaciones"> Publicaciones </option>
			</select>
		</td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Nombre del documento </label></td>
        <td>
        	<p><img src="extension/<?php $imgExt = strtolower(pathinfo($edit_row['docFile'],PATHINFO_EXTENSION)); echo $imgExt; ?>.png" height="150" width="150" class="img-thumbnail"/></p>
        	<p><?php echo $edit_row['docFile'] ; ?></p>
        	<input class="input-group" type="file" name="user_image" accept="*" />
        </td>
    </tr>
    
    <tr>
    	<form method="post" enctype="multipart/form-data" class="form-horizontal">
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Actualizar
        </button>
        
        <a class="btn btn-default" href="users.php"> <span class="glyphicon glyphicon-backward"></span> Cancelar </a>
    </form>
        
        </td>
    </tr>
    
    </table>
    
</form>
</div>
</div>


<?php
require_once 'views/footer.php';
?>