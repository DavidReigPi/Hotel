<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/cliente', name: 'api_cliente')]
class BasicClienteController extends AbstractController
{
    
    public function __construct(private ClienteRepository $clienteRepo)
    {
        
    }

    #[Route('/basic/cliente', name: 'app_basic_cliente')]
    public function index(): Response
    {
        $cliente1 = new Cliente();
        $cliente1->setDni('22406390T');
        $cliente1->setName('Guillermo');
        $cliente1->setDirecction('Avenida Libertad');

        $this->clienteRepo->save($cliente1, true);

        $clientes = $this->clienteRepo->FindAll();

        return $this->render('basic_cliente/index.html.twig', [
            'controller_name' => 'BasicClienteController',
            'clienteArray'=>$clientes
        ]);
    }

    #[Route('/show', name: 'api_clientes_show_all', methods:['get'] )]
    public function showAll(): Response
    {
        $clientes = $this->clienteRepo->findAll();

        /*return $this->json([
            'clienteArray'=> $clientes,
        ], 200);*/
        $data = [];
   
        foreach ($clientes as $cliente) {
           $data[] = [
               'id' => $cliente->getId(),
               'name' => $cliente->getName(),
               'direcction' => $cliente->getDirecction(),
               'dni' => $cliente->getDni(),
           ];
        }
   
        return $this->json($data, 200);
    }

    #[Route('/new', name: 'api_crear_cliente', methods:['post'] )]
    public function create(Request $request): Response
    {
        $cliente4 = new Cliente();
        $cliente4 -> setDni($request->request->get('dni'));
        $cliente4 -> setName($request->request->get('name'));
        $cliente4 -> setDirecction($request->request->get('direcction'));

        $this->clienteRepo->save($cliente4, true);

        /*return $this->json([
            'clienteArray' => $cliente4,    esto no muestra los datos asi que
        ], 201);                          lo hacemos como se muestra abajo*/
        $data = [
            'name'=> $cliente4->getName(),
            'dni'=> $cliente4->getDni(),
            'direcction'=>$cliente4->getDirecction()
        ];

        return $this->json($data);
    }

    #[Route('/{id}/edit', name: 'api_editar_cliente', methods:['put', 'post'])]
    public function edit(int $id, Request $request): Response
    {
        $clientes = $this->clienteRepo->find($id);

        $clientes -> setDni($request->request->get('dni'));
        $clientes -> setName($request->request->get('name'));
        $clientes -> setDirecction($request->request->get('direcction'));

        $this->clienteRepo->save($clientes, true);

        /*return $this->json([
            'clienteArray' => $clientes
        ], 201);*/

        $data = [
            'name'=> $clientes->getName(),
            'dni'=> $clientes->getDni(),
            'direcction'=>$clientes->getDirecction()
        ];

        return $this->json($data);
    }

    #[Route('/{id}', name: 'api_borrar_cliente', methods:['delete'])]
    public function delete(int $id): Response
    {
        $cliente = $this->clienteRepo->find($id);

        if (!$cliente) {
            return $this->json('Cliente no encontrado por id' . $id, 404);
        }

        $this->clienteRepo->remove($cliente, true);

         return $this->json([
            'Mensaje!' => 'Cliente borrado con id '. $id
        ], 201);

    }

}