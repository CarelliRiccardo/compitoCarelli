<?php

require 'vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Squadra {
    public $id;
    public $nome;
    public $colore;
    public $genere;
    public $categoria;
    public $codice_csen;
    public $p_iva;

    public function __construct($id, $nome, $colore, $genere, $categoria = null, $codice_csen = null, $p_iva = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->colore = $colore;
        $this->genere = $genere;
        $this->categoria = $categoria;
        $this->codice_csen = $codice_csen;
        $this->p_iva = $p_iva;

        new Squadra(1, "Juventus", "bianco e nero", "maschile", null, "CS123", "12345678901"),
        new Squadra(2, "Milan", "rosso e nero", "maschile", null, "CS456", "23456789012"),
        new Squadra(3, "Inter", "nero e azzurro", "maschile", null, "CS789", "34567890123"),
        new Squadra(4, "Roma", "giallo e rosso", "maschile", null, "CS012", "45678901234"),
        new Squadra(5, "Juventus Femminile", "bianco e nero", "femminile", "A", null, null),
        new Squadra(6, "Milan Femminile", "rosso e nero", "femminile", "B", null, null),
    }

    public function s1 (Request $request, Response $response) use ($squadre) {
        $response->getBody()->write(json_encode($squadre));
        return $response->withHeader('Content-Type', 'application/json');
    };

    public function s2 (Request $request, Response $response, $args) use ($squadre) {
        $id = $args['id'];
        foreach ($squadre as $squadra) {
            if ($squadra->id == $id) {
                $response->getBody()->write(json_encode($squadra));
                return $response->withHeader('Content-Type', 'application/json');
            }
        }
        $response->getBody()->write(json_encode(['error' => 'Squadra non trovata']));
        return $response->withHeader('Content-Type', 'application/json');
    };
    
}
?>