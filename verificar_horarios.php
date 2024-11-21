<?php
include_once('config.php');

$data = mysqli_real_escape_string($conexao, $_GET['data']);
$query = "SELECT hr_corte FROM agendamento WHERE dt_corte = '$data'";
$result = mysqli_query($conexao, $query);

$horarios = [];
while ($row = mysqli_fetch_assoc($result)) {
    $horarios[] = $row['hr_corte'];
}

echo json_encode(['horarios' => $horarios]);
?>
