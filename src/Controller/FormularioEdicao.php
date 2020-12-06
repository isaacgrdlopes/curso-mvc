<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FormularioEdicao implements RequestHandlerInterface
{
    use RenderizadorDeHtmlTrait;
    
    private $repositorioCursos;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repositorioCursos = $this->entityManager->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getQueryParams('id', FILTER_VALIDATE_INT);

        if (is_null($id) || $id === false){
            return new Response(200, ['Location' => '/listar-cursos']);
        }

        $curso = $this->repositorioCursos->find($id);
        
        $html = $this->renderizaHtml('cursos/formulario.php', [
            'titulo' => "Alterar Curso", 
            'curso' => $curso]);

            return new Response(200, [], $html);
    }
}