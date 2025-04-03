<?php 
/**
 * @author Alejandro Fernández Arrayás
 * 
 * Mostrar un calendario mensual basado en las variables $mes y $año.
 * El día actual se marca en verde si coincide con la fecha almacenada en $actual.
 * Los domingos se marcan en rojo.
 */
setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain', 'es_ES', 'es'); // Configurar en español

// Variables de mes y año

//Valor Inicial
$mes = 4; 
$año = 2025;

//Comprobamos que se haya mandado el formulario antes de guardar los datos
if(isset($_POST['mes']) && isset($_POST['año'])){
    $mes = $_POST['mes'];
    $año = $_POST['año'];
}

// Fecha actual
$actual = date("Y-m-d");

// Nombre del mes
$mes_texto = strftime("%B", strtotime("$año-$mes-01"));
$mes_texto = ucfirst($mes_texto);

// Número de días en el mes
$numDiasMes = date("t", strtotime("$año-$mes-01"));

// Día de la semana del primer día del mes ( 0=>domingo  6=>sábado )
$diaUno = strtotime("$año-$mes-01");
$primerDiaMes = date("w", $diaUno);

function nombreDia($dia, $mes, $año) {
    $fecha = strtotime("$año-$mes-$dia");
    $diaActual = strftime("%A", $fecha);
    return ucfirst($diaActual);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
    <style>
        body{
            align-items: center;
            text-align: center;
        }
        .calendario {
            display: grid;
            grid-template-columns: repeat(7, 0fr);
            text-align: center;
            justify-content: center;
        }
        .dia, .nombre-dia {
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 2px;
            background-color: lightgray;
            border-radius: 5px;
            font-size: 1.5em;
        }
        .dia.drojo {
            background-color: red;
            color: white;
        }
        .dia.dverde {
            background-color: green;
            color: white;
        }
        .nombre-dia {
            font-weight: bold;
            background-color: darkgray;
            color: white;
        }

        form{
            display: flex;
            flex-direction: column;
            width: 40em;
        }
    </style>
</head>
<body>
    <h1>CALENDARIO</h1>
    <h2><?php echo $mes_texto . " " . $año; ?></h2>
    <div class='calendario'>
        <?php 
        // Nombres de los días de la semana
        $diasSemana = ['Lun', 'Mar', 'Miér', 'Jue', 'Vier', 'Sáb', 'Dom'];
        foreach ($diasSemana as $dia) {
            echo "<div class='nombre-dia'>$dia</div>";
        }

        // Espacios en blanco iniciales
        $espacios = ($primerDiaMes == 0) ? 6 : $primerDiaMes - 1;
        for ($i = 0; $i < $espacios; $i++) { 
            echo "<div class='dia'></div>";
        }
        
        // Días del mes
        for ($i = 1; $i <= $numDiasMes; $i++) {
            $nombreDia = nombreDia($i, $mes, $año);
            $clase = 'dia';
            $diaActual = date("Y-m-d", strtotime("$año-$mes-$i"));
            
            if ($nombreDia == 'Domingo') {
                $clase .= ' drojo';
            } elseif ($diaActual == $actual) {
                $clase .= ' dverde';
            }
            
            echo "<div class='$clase'>$i</div>";
        }
        ?>
    </div>

    <div class="formCaln">
        <h2>Introduce el Año y el Mes</h2>
        <form method="post" action="index.php">
            <label for="año">Introduce el año</label>
            <input type="number" id="año" name="año" min=1920 max=2100>
            <label for="mes">Introduce el Mes</label>
            <select name="mes" id="mes">
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>