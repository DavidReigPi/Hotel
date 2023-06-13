<?php

namespace App\Controller;

use App\Entity\Director;
use App\Repository\DirectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/director', name: 'api_director')]
class BasicDirectorController extends AbstractController
{
    //private $directorRepo;

    public function __construct(private DirectorRepository $directorRepo)
    {

    }
    #[Route('/basic/director', name: 'app_basic_director')]
    public function index(): Response
    {
        $director1 = new Director();
        $director1->setDni('22.123.456H');
        $director1->setNombre('Emilio');

        $this->directorRepo->save($director1, true);

        $directors = $this->directorRepo->findAll();



        return $this->render('basic_director/index.html.twig', [
            'controller_name' => 'BasicdirectorController',
            'directorArray'=>$directors
        ]);
    }

    #[Route('/show', name: 'api_directors_mostrar_todo', methods:['get'] )]
    public function showAll(): Response
    {
        $directors = $this->directorRepo->findAll();

        /*return $this->json([
            'directorArray'=> $directors,
        ], 200);*/
        $data = [];
   
        foreach ($directors as $director) {
           $data[] = [
               'id' => $director->getId(),
               'dni' => $director->getDni(),
               'nombre' => $director->getNombre(),
           ];
        }
   
        return $this->json($data, 200);
    }

    #[Route('/new', name: 'api_crear_director', methods:['post'] )]
    public function create(Request $request): Response
    {
        $director = new Director();
        $director -> setDni($request->request->get('dni'));
        $director -> setNombre($request->request->get('nombre'));

        $this->directorRepo->save($director, true);

        /*return $this->json([
            'directorArray' => $director,    esto no muestra los datos asi que
        ], 201);                          lo hacemos como se muestra abajo*/
        $data = [
            'name'=> $director->getNombre(),
            'dni'=> $director->getDni(),
        ];

        return $this->json($data, 201);
    }

    #[Route('/{id}/edit', name: 'api_editar_director', methods:['put', 'post'])]
    public function edit(int $id, Request $request): Response
    {
        $directors = $this->directorRepo->find($id);

        $directors -> setDni($request->request->get('dni'));
        $directors -> setNombre($request->request->get('name'));
        

        $this->directorRepo->save($directors, true);

        /*return $this->json([
            'directorArray' => $directors
        ], 201);*/

        $data = [
            'name'=> $directors->getNombre(),
            'dni'=> $directors->getDni(),
        ];

        return $this->json($data, 201);
    }

    

}
