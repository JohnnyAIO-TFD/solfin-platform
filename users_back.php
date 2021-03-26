<?php
	session_start();
	require_once 'dbconfig.php';

	if (isset($_SESSION['logged']) || $_SESSION['logged'] == true) {
		//echo "Sesión Iniciada <br>";
	} else {
   	echo "Inicia Sesion para acceder a este contenido.<br>";
   	echo "<br><a href='index.html'>Login</a>";
   	header('Location:index.html');//redirige a la página de login si el usuario quiere ingresar sin iniciar sesion
	exit;
	}
	
	if(isset($_GET['delete_id']))
	{
		$stmt_select = $DB_con->prepare('SELECT docFile FROM tbl_docs WHERE docID =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("user_files/".$imgRow['docFile']);
		
		$stmt_delete = $DB_con->prepare('DELETE FROM tbl_docs WHERE docID =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		header("Location: users.php");
	}

	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page = 1;
	}
	require_once 'views/header.php';
?>


<div class="container text-center">

	<div class="page-header">
    	<h1 class="h2">Plataforma de Archivos SOLFIN / <a class="btn btn-default" href="addnew.php"> <span class="glyphicon glyphicon-plus"></span> &nbsp; Subir Archivos </a></h1> 
    </div>


<table class="table" align="center">
  			<thead>
    			<tr>
      				<th scope="col"> Formato del Archivo </th>
      				<th scope="col">Nombre del Archivo</th>
      				<th scope="col">Fecha de la subida de archivo </th>
      				<th scope="col">Departamento </th>
    			</tr>
  </thead>
<?php
    $limit = 5;
	$start = ($page-1)*$limit;
	//$stmt = $DB_con->prepare('SELECT docID, docType, docFile, docDate FROM tbl_docs ORDER BY docID DESC');
	$stmt = $DB_con->prepare("SELECT * FROM tbl_docs ORDER BY docDate DESC LIMIT $start,$limit" );
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			$extn = strtolower(pathinfo($row['docFile'],PATHINFO_EXTENSION));
			$extn2 = strtolower(pathinfo($row['docFile'],PATHINFO_EXTENSION));
			switch ($extn){
				case "png": $extn="PNG Image"; break;
				case "jpg": $extn="JPEG Image"; break;
				case "jpeg": $extn="JPEG Image"; break;
				case "svg": $extn="SVG Image"; break;
				case "gif": $extn="GIF Image"; break;
				case "ico": $extn="Windows Icon"; break;

				case "txt": $extn="Text File"; break;
				case "log": $extn="Log File"; break;
				case "htm": $extn="HTML File"; break;
				case "html": $extn="HTML File"; break;
				case "xhtml": $extn="HTML File"; break;
				case "shtml": $extn="HTML File"; break;
				case "php": $extn="PHP Script"; break;
				case "js": $extn="Javascript File"; break;
				case "css": $extn="Stylesheet"; break;

				case "pdf": $extn="PDF Document"; break;
				case "xls": $extn="Spreadsheet"; break;
				case "xlsx": $extn="Spreadsheet"; break;
				case "doc": $extn="Microsoft Word Document"; break;
				case "docx": $extn="Microsoft Word Document"; break;

				case "zip": $extn="ZIP Archive"; break;
				case "htaccess": $extn="Apache Config File"; break;
				case "exe": $extn="Windows Executable"; break;

				default: if($extn!=""){$extn=strtoupper($extn)." File";} else{$extn="Unknown";} break;
			}

			?>
			
  <tbody>
    <tr>
      <th scope="row" >  <img src="extension/<?php echo $extn2; ?>.png" width="50px" height="50px" /> </p> </th>
        <td> <p class="page-header"><?php echo $row['docFile']?> </p> </td>
      <td><p class="page-header"><?php echo $row['docDate'] ?> </td>
      <td> <p class="page-header"><?php echo $docType; ?></p> </td>
     <td>
			<!-- <a class="btn btn-info" href="editform.php?edit_id=<?php echo $row['docID']; ?>" title="click for edit"><span class="glyphicon glyphicon-edit"></span> Editar </a></td> -->
			<td><a class="btn btn-primary" href="user_files/<?php echo $row['docFile']; ?>" title="click for edit" target="_blank"><span class="glyphicon glyphicon-edit"></span> Visualizar </a> </td>
			<td>
			<a class="btn btn-danger" href="?delete_id=<?php echo $row['docID']; ?>" title="click for delete" onclick="return confirm('¿Desea eliminar el archivo ?')"><span class="glyphicon glyphicon-remove-circle"></span> Eliminar </a></span></td>
			
        
			<?php
		}
	}
	else
	{
		?>
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> No hay archivos disponibles.
            </div>
        </div>
        <?php
	}
	
?>
   </tr>
  </tbody>
</table>
</div>	

<?php
$stmt = $DB_con->prepare("SELECT COUNT(docID) AS total FROM tbl_docs" );
$stmt->execute();
//$row=$stmt->rowCount();
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$total_pages = ceil($row["total"] / $limit);   
echo "<center> ";
for ($i=1; $i<=$total_pages; $i++) { 
			
            echo "<a class='btn btn-primary' href='users.php?page=".$i."'";
            if ($i==$page)  echo " class='curPage'";
            echo ">".$i."</a> ";
             
}; 
echo "</center> ";


require_once 'views/footer.php';
?>