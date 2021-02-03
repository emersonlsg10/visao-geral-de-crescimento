<?php
$quantidadeMeses = isset($_POST['quantidadeMeses']) ? (int) $_POST['quantidadeMeses'] : 0;
$numeroNovoContratosPorMes = isset($_POST['numeroNovoContratosPorMes']) ? (int)$_POST['numeroNovoContratosPorMes'] : 0;
$valorDeCadaContrato = isset($_POST['valorDeCadaContrato']) ? (float)$_POST['valorDeCadaContrato'] : 0;
echo "<form method='post'>";
echo "<label>Quantidade de mês para simular: </label>";
echo "<input type='text' name='quantidadeMeses' value='{$quantidadeMeses}'/><br>";
echo "<label>Número de novos contratos: </label>";
echo "<input type='text' name='numeroNovoContratosPorMes' value='{$numeroNovoContratosPorMes}'/><br>";
echo "<label>Valor de cada contrato: </label>";
echo "<input type='number' name='valorDeCadaContrato' value='{$valorDeCadaContrato}'/><br>";
echo "<button type='submit'>Mostrar resultado</button>";
echo "</form>";
if (!isset($_POST['quantidadeMeses'])) {
    exit;
}
if (!$quantidadeMeses) {
    exit("Informe a quantidade de meses para simular");
}
$transacoes = [];
$dataInicio = $mesAtual = date('Y-01-01');
while ($mesAtual <= date('Y-m-d', strtotime("+" . ($quantidadeMeses - 1) . "months", strtotime($dataInicio)))) {
    for ($cliente = 1; $cliente <= $numeroNovoContratosPorMes; $cliente++) {
        $transacoes[] = [
            'data' => $mesAtual,
            'cliente' => 'cliente-' . date('MY', strtotime($mesAtual)) . '-' . $cliente,
            'valor' => $valorDeCadaContrato
        ];
    }
    $mesAtual = date('Y-m-d', strtotime("+1months", strtotime($mesAtual)));
}
//Escreva seu código aqui, sem alterar o código acima


/*
*   @ return $numeroNovoContratosPorMes ou vazio
*/
function contaDatasAnteriores($data, $transacoes, $numeroNovoContratosPorMes, $linhaMes)
{
    $contador = 0;
    $quantidadeTransacoes = sizeof($transacoes);

    for ($j = 0; $j < $quantidadeTransacoes; $j++) {
        if ($transacoes[$j]['data'] <= $data) {
            $contador++;
        }
    }

    if ($contador <= $numeroNovoContratosPorMes * $linhaMes)
        return $numeroNovoContratosPorMes;
    else return '';
}


echo "<table border='1'>";

// Monta a quantidade de mêses nas colunas
echo "<tr>";
echo "<td>Meses</td>";
for ($contadorColuna = 1; $contadorColuna <=  $quantidadeMeses; $contadorColuna++) {
    echo "<td>$contadorColuna º Mes</td>";
}
echo "</tr>";
// Termina de montar a quantidade de mês nas colunas


// monta a quantidade de linhas nas colunas
$controleMes = date('Y-01-01');
for ($contadorLinha = 1; $contadorLinha <= $quantidadeMeses; $contadorLinha++) {
    echo "<tr>";
    echo "<td></td>";

    for ($celulaPorMes = 1; $celulaPorMes <= $quantidadeMeses; $celulaPorMes++) {

        // verifica se vai renderizar o $numeroNovoContratosPorMes ou vazio na célula
        echo "<td>" . contaDatasAnteriores($controleMes, $transacoes, $numeroNovoContratosPorMes, $celulaPorMes) . "</td>";
    }

    $controleMes = date('Y-m-d', strtotime("+1months", strtotime($controleMes)));
    echo "</tr>";
}
// termina de montar a quantidade de linhas nas colunas


// monta a linha de adesões no mês
echo "<tr>";
echo "<td>VALOR TOTAL DE ADESÕES NO MÊS</td>";
for ($linhaMes = 1; $linhaMes <= $quantidadeMeses; $linhaMes++) {
    echo "<td> R$ " . $numeroNovoContratosPorMes *  $transacoes[$linhaMes]['valor'] . "</td>";
}
echo "</tr>";
// termina de montar a linha de adesões no mês


// monta a linha de adesões acumulado
echo "<tr>";
echo "<td>VALOR TOTAL DE ADESÕES ACUMULADO</td>";
for ($linhaMes = 1; $linhaMes <= $quantidadeMeses; $linhaMes++) {
    echo "<td> R$ " . $linhaMes * $numeroNovoContratosPorMes *  $transacoes[$linhaMes]['valor'] . "</td>";
}
echo "</tr>";
// termina de montar a linha de adesões acumulado

echo "</table>";
// termina de montar a tabela