<?php
//aqui se pueden instanciar funciones y metodos globales tambien conocidos como helpers
//tambien se puede usar para funciones que se usen en varios controladores
//tambien se pueden usar para funciones que se usen en vistas blade

if (! function_exists('saludar')) {
    function saludar($nombre) {
        return "Hola, $nombre";
    }
}


//crear una funcion que me haga el tipo de cambio de cada dolar que valga a 12.5 
if (! function_exists('convertirDolarAPeso')) {
    function convertirDolarAPeso($dolares) {
        $tipoDeCambio = 12.5;
        return $dolares * $tipoDeCambio;
    }
}
