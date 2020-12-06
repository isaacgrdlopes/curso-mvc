<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Exclusao implements RequestHandlerInterface
{
    use FlashMessageTrait;

    private $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator)
        ->getEntityManager();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (is_null($id) || $id === false) {
            $this->defineMensagem('danger', 'Curso inexistente');
            return new Response(200, ['Location' => '/listar-cursos']);
        }

        $curso = $this->entityManager->getReference(Curso::class, $id);
        $this->entityManager->remove($curso);
        $this->entityManager->flush();

        $this->defineMensagem('success', 'Curso excluido com sucesso');

        return new Response(200, ['Location' => '/listar-cursos']);
    }

}
