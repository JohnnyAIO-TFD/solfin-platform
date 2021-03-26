	       	<style>
	       .solfin-bar{
	           padding: 20px 30px;
	           background-color: #0D3F7C;
	           color: #fff;
	           font-family: 'Noto Sans', sans-serif;
	           font-size: 16px;
	           border-radius: 0px;
	       }

	
	       .solfin-table{
	           border: none;
	           margin: 30px;
	           width: 600px;
	           text-align: 'center';
	       }
	       
	   </style>

<?php
require_once 'dbconfig.php';
// echo "Esto es una prueba desde publicacion <br/>";
    $limit = 5;
	$start = 0;
	$stmt = $DB_con->prepare("SELECT * FROM tbl_docs WHERE docType='Cumplimiento' ORDER BY docDate DESC LIMIT $start,$limit ");
	
	
	$stmt->execute();
	
	if($stmt->rowCount() > 0){
	    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
	        
	       // extract($row);
	       // echo "<a> href='user/$row['docFile']'  ". $row['docFile'] .' </a> <br/>';
	       
	       ?>

	       <table class='solfin-table'>
	           <td class='solfin-table'> <a class='solfin-bar' href="../pl1t1_s8lf90/user_files/<?php echo $row['docFile']; ?>" target="_blank"> <bold> <?php echo $row['docFile']; ?> </bold> </a> <br/>  </td>
	           
	       </table>
	       
	       
	       
	       <?php
	    }
	    
	}
	 
?>
		