<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Usuario;

/**
 * @Route("/api/v1", name="api_v1_usuario_")
 */
class UsuarioController extends AbstractController {

    /**
     * @Route("/lista", methods={"GET"}, name="lista")
     */
    public function lista(): JsonResponse
    {
        $doctrine =  $this->getDoctrine()->getRepository(Usuario::class);

        return new JsonResponse($doctrine->pegarTodos());
    }

    /**
     * @Route("/cadastra", methods={"POST"}, name="cadastra")
     */
    public function cadastra(Request $request): Response
    {

        $data = $request->query->all();

        $usuario = new Usuario;
        $usuario->setNome($data['nome']);
        $usuario->setEmail($data['email']);
        
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($usuario);
        $doctrine->flush();

        if($usuario->getId()){
            return new Response("OK", 200);
        }
  
        return new Response("Error", 404);
    }
}