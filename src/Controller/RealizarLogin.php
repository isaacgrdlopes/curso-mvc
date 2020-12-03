<?php

namespace Alura\Cursos\Controller;

class RealizaLogin implements InterfaceControladorRequisicao
{
    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if (is_null($email) || $email === false){
            echo "E-mail inválido";
            exit();
        }
    }
}