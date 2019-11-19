<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Usuario;

/**
 * @Route("/", name="web_usuario_")
 */
class UsuarioController extends AbstractController 
{

    /**
     * @Route("/", methods={"GET"}, name="index")
     */
    public function index(): Response
    {
        return $this->render("usuario/form.html.twig");
    }

    /**
     * @Route("/salvar", methods={"POST"}, name="salvar")
     */
    public function salvar(Request $request): Response
    {
        $data = $request->request->all();

        $usuario = new Usuario;
        $usuario->setNome($data['nome']);
        $usuario->setEmail($data['email']);
        
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($usuario);
        $doctrine->flush();

        if($usuario->getId()){
            return $this->render("usuario/sucesso.html.twig", [
                "fulano" => $data['nome']
            ]);
        }
        
        return $this->render("usuario/erro.html.twig", [
            "fulano" => $data['nome']
        ]);
    }
}