<?php
$q = strtolower($_GET['q'] ?? '');

$articulos = [
    [
        'titulo' => 'Has oído hablar sobre el modelo de equidad de género llamado MEG?, aquí te contamos que es.',
        'url' => '#',
        'categoria' => 'TENDENCIAS'
    ],
    [
        'titulo' => 'ONU alerta sobre el retroceso en derechos de las mujeres a nivel global',
        'url' => '#',
        'categoria' => 'RECOMENDACIONES'
    ],
    [
        'titulo' => 'Un país alcanza por primera vez la paridad de género en el gobierno',
        'url' => '#',
        'categoria' => 'TENDENCIAS, RECOMENDACIONES'
    ]
];

$resultados = [];
foreach ($articulos as $articulo) {
    if (str_contains(strtolower($articulo['titulo']), $q)) {
        $resultados[] = $articulo;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
    <link rel="stylesheet" href="css/global.css">
</head>
<body>
    <h1>Resultados para: <?= htmlspecialchars($q) ?></h1>

    <?php if (count($resultados)): ?>
        <ul>
        <?php foreach ($resultados as $art): ?>
            <li>
                <a href="<?= $art['url'] ?>"><?= $art['titulo'] ?></a> (<?= $art['categoria'] ?>)
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>
</body>
</html>
