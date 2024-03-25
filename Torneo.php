<?php
require 'vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Torneo {
    public $nome;
    public $codice;
    public $data;
    public $sede;
    public $elenco_di_partite;

    public function __construct($nome, $codice, $data, $sede, $elenco_di_partite) {
        $this->nome = $nome;
        $this->codice = $codice;
        $this->data = $data;
        $this->sede = $sede;
        $this->elenco_di_partite = $elenco_di_partite;
    }

    public function t1(Request $request, Response $response, $args) use ($torneo) {
        $codice = $args['codice'];
        if ($codice == $torneo->codice) {
            $response->getBody()->write(json_encode($torneo));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Torneo non trovato']));
        }
        return $response->withHeader('Content-Type', 'application/json');
    };
    
    public function partite (Request $request, Response $response, $args) use ($torneo) {
        $codice = $args['codice'];
        if ($codice == $torneo->codice) {
            $response->getBody()->write(json_encode($torneo->elenco_di_partite));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Torneo non trovato']));
        }
        return $response->withHeader('Content-Type', 'application/json');   
    };

    function disputate (Request $request, Response $response, $args) use ($torneo) {
        $codice = $args['codice'];
        if ($codice == $torneo->codice) {
            $partite_disputate = array_filter($torneo->elenco_di_partite, function($partita) {
                return $partita->goals_squadra_1 !== null && $partita->goals_squadra_2 !== null;
            });
            $response->getBody()->write(json_encode($partite_disputate));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Torneo non trovato']));
        }
        return $response->withHeader('Content-Type', 'application/json');
    };
    
    public function da_disputare(Request $request, Response $response, $args) use ($torneo) {
        $codice = $args['codice'];
        if ($codice == $torneo->codice) {
            $partite_da_disputare = array_filter($torneo->elenco_di_partite, function($partita) {
                return $partita->goals_squadra_1 === null || $partita->goals_squadra_2 === null;
            });
            $response->getBody()->write(json_encode($partite_da_disputare));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Torneo non trovato']));
        }
        return $response->withHeader('Content-Type', 'application/json');
    };

    function t2(Request $request, Response $response, $args) use ($torneo) {
        $codice = $args['codice'];
        $id_partita = $args['id_partita'];
        if ($codice == $torneo->codice) {
            foreach ($torneo->elenco_di_partite as $partita) {
                if ($partita->id == $id_partita) {
                    $response->getBody()->write(json_encode($partita));
                    return $response->withHeader('Content-Type', 'application/json');
                }
            }
            $response->getBody()->write(json_encode(['error' => 'Partita non trovata']));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Torneo non trovato']));
        }
        return $response->withHeader('Content-Type', 'application/json');
    };
    function concluso(Request $request, Response $response, $args) use ($torneo) {
        $codice = $args['codice'];
        if ($codice == $torneo->codice) {
            $partite_disputate = array_filter($torneo->elenco_di_partite, function($partita) {
                return $partita->goals_squadra_1 !== null && $partita->goals_squadra_2 !== null;
            });
            $concluso = count($partite_disputate) == count($torneo->elenco_di_partite);
            $response->getBody()->write(json_encode(['concluso' => $concluso]));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Torneo non trovato']));
        }
        return $response->withHeader('Content-Type', 'application/json');
    };
    function classifica (Request $request, Response $response, $args) use ($torneo, $squadre) {
        $codice = $args['codice'];
        if ($codice == $torneo->codice) {
            $classifica = [];
            foreach ($squadre as $squadra) {
                $punti = 0;
                foreach ($torneo->elenco_di_partite as $partita) {
                    if ($partita->squadra_1 == $squadra->nome) {
                        if ($partita->goals_squadra_1 > $partita->goals_squadra_2) {
                            $punti += 3;
                        } elseif ($partita->goals_squadra_1 == $partita->goals_squadra_2) {
                            $punti += 1;
                        }
                    } elseif ($partita->squadra_2 == $squadra->nome) {
                        if ($partita->goals_squadra_2 > $partita->goals_squadra_1) {
                            $punti += 3;
                        } elseif ($partita->goals_squadra_1 == $partita->goals_squadra_2) {
                            $punti += 1;
                        }
                    }
                }
                $classifica[] = ['squadra' => $squadra->nome, 'punti' => $punti];
            }
            usort($classifica, function($a, $b) {
                return $b['punti'] - $a['punti'];
            });
            $response->getBody()->write(json_encode($classifica));
        } else {
            $response->getBody()->write(json_encode(['error' => 'Torneo non trovato']));
        }
        return $response->withHeader('Content-Type', 'application/json');
    };
    
}


?>

