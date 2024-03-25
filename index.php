<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';



function autoloader($class) {
    $dir = ['', '/controllers', 'src'];
    foreach ($dir as $d) {
        $file = __DIR__ . '/' . $d . '/' . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
}
spl_autoload_register('autoloader');
$app = AppFactory::create();
$squadre = [
    new Squadra(1, "Juventus", "bianco e nero", "maschile", null, "CS123", "12345678901"),
    new Squadra(2, "Milan", "rosso e nero", "maschile", null, "CS456", "23456789012"),
    new Squadra(3, "Inter", "nero e azzurro", "maschile", null, "CS789", "34567890123"),
    new Squadra(4, "Roma", "giallo e rosso", "maschile", null, "CS012", "45678901234"),
    new Squadra(5, "Juventus Femminile", "bianco e nero", "femminile", "A", null, null),
    new Squadra(6, "Milan Femminile", "rosso e nero", "femminile", "B", null, null),
];

$partite = [
    new Partita(1, "Juventus", "Milan", 2, 1),
    new Partita(2, "Inter", "Roma", 0, 0),
];


$torneo = new Torneo("Serie A", "SA2024", "2024-01-01", "Stadio Olimpico", $partite);

$app->get('/torneo/{codice}', 'ControllerTorneo:torneo');
$app->get('/squadre', 'ControllerSquadre:squadre');
$app->get('/squadre/{id}', 'ControllerSquadre:squadre')
$app->get('/torneo/{codice}/partite', 'ControllerTorneo:torneo');
$app->get('/torneo/{codice}/partite/disputate', 'ControllerTorneo');
$app->get('/torneo/{codice}/partite/da_disputare', 'ControllerTorneo');
$app->get('/torneo/{codice}/partite/{id_partita}', 'ControllerTorneo');
$app->get('/torneo/{codice}/concluso', 'ControllerTorneo');
$app->get('/torneo/{codice}/classifica', 'ControllerTorneo');

$app->run();
