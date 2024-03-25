<?php
require 'vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Partita {
    public $id;
    public $squadra_1;
    public $squadra_2;
    public $goals_squadra_1;
    public $goals_squadra_2;

    public function __construct($id, $squadra_1, $squadra_2, $goals_squadra_1, $goals_squadra_2) {
        $this->id = $id;
        $this->squadra_1 = $squadra_1;
        $this->squadra_2 = $squadra_2;
        $this->goals_squadra_1 = $goals_squadra_1;
        $this->goals_squadra_2 = $goals_squadra_2;
    }
}

?>