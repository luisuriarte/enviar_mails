<?php
// Incluimos el archivo de conexion
include_once("db_connect.php");

// Consulta para lista clientes DB
$query = "SELECT c.pc_pid, CONCAT(p.fname, ' ', p.mname, ' ',p.lname) nombre, p.phone_cell Celular, p.email correo, c.pc_eventDate fecha_turno, c.pc_startTime hora_turno, CONCAT(u.fname,' ' ,u.mname,' ' , u.lname) 'Profesional'
FROM openemr_postcalendar_events c 
 	INNER JOIN users u ON u.id = c.pc_aid
	INNER JOIN patient_data p ON c.pc_pid = p.pid
WHERE c.pc_eventDate = CURDATE() OR c.pc_eventDate = DATE_ADD(CURDATE(),INTERVAL 2 DAY)";

$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
<title>Recordatorios</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<br />
<div class="container">
<h3 align="left">Enviar Recordatorios de Turnos</h3>
<br />
<div class="table-responsive">
<table class="table table-bordered table-striped">
<tr>
<th>Nombre Pacientes</th>
<th>Correo</th>
<th>Fecha Turno</th>
<th>Hora Turno</th>
<th>Selección</th>
<th>Acción</th>
</tr>
<?php
$count = 0;
foreach($result as $row)
{
$count = $count + 1;
echo '
<tr>
<td>'.$row["nombre"].'</td>
<td>'.$row["correo"].'</td>
<td>'.$row["fecha_turno"].'</td>
<td>'.$row["hora_turno"].'</td>
<td>
<input type="checkbox" name="single_select" class="single_select" data-email="'.$row["correo"].'" data-name="'.$row["nombre"].'" />
</td>
<td>
<button type="button" name="email_button" class="btn btn-info btn-xs email_button" id="'.$count.'" data-email="'.$row["correo"].'" data-name="'.$row["nombre"].'" data-action="single">Enviar</button>
</td>
</tr>
';
}
?>
<tr>
<td colspan="4"></td>
<td><button type="button" name="select_email" class="btn btn-info email_button" id="select_email" data-action="bulk">Enviar </button></td>
</tr>
</table>
</div>
</div>
</body>
</html>

<script>
$(document).ready(function(){
$('.email_button').click(function(){
$(this).attr('disabled', 'disabled');
var id = $(this).attr("id");
var action = $(this).data("action");
var email_data = [];
if(action == 'single')
{
email_data.push({
email: $(this).data("email"),
name: $(this).data("name")
});
}
else
{
$('.single_select').each(function(){
if($(this).prop("checked") == true)
{
email_data.push({
email: $(this).data("email"),
name: $(this).data('name')
});
}
});
}

$.ajax({
url:"enviar_mail.php",
method:"POST",
data:{email_data:email_data},
beforeSend:function(){
$('#'+id).html('Enviando...');
$('#'+id).addClass('btn-danger');
},
success:function(data){
if(data == 'ok')
{
$('#'+id).text('Enviado');
$('#'+id).removeClass('btn-danger');
$('#'+id).removeClass('btn-info');
$('#'+id).addClass('btn-success');
}
else
{
$('#'+id).text(data);
}
$('#'+id).attr('disabled', false);
}
})

});
});
</script>
