<?php

namespace App\Controller;

use App\Repository\ClienteRepository;
use App\Entity\Cliente;
use App\Entity\Room;
use App\Repository\RoomRepository;
use App\Entity\Director;
use App\Entity\Hotel;
use App\Repository\DirectorRepository;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasicHotelController extends AbstractController
{
    //private $hotelRepo;

    public function __construct(private HotelRepository $hotelRepo, private DirectorRepository $directorRepo,
    private RoomRepository $roomRepo)
    
    {
        //$this->hotelRepo = $hotelRepo;
    }
    
    #[Route('/basic/hotel', name: 'app_basic_hotel')]
    public function index(): Response
    {
        $hotel1 = new Hotel();
        $hotel1->setName('Melia');
        $hotel1->setCity('Alicante');
        $hotel1->setNRooms(50);
        $hotel1->setAddress('Puerto Alicante');

        //$director = $this->directorRepo->find(1);

        $director1 = new Director();
        $director1->setDni('22.123.456H');
        $director1->setNombre('Emilio');

        $hotel1->setDirectorId($director1);
        
        // podemos crear una habitacion aqui tambien como el director
        //$room = $this->roomRepo->find(1);

        $this->hotelRepo->save($hotel1, true);

        //Creamos otro Hotel
        $hotel2 = new Hotel();
        $hotel2->setName('Barcelo');
        $hotel2->setCity('Punta Cana');
        $hotel2->setNRooms(50);
        $hotel2->setAddress('AVDA. El Paraiso');

        $cliente2 = new Cliente();
        $cliente2->setDni('224555555Q');
        $cliente2->setName('Paula');
        $cliente2->setDirecction('C/ El Salto');

        $hotel2->addClienteId($cliente2);

        $this->hotelRepo->save($hotel2, true);
        
        $hotels = $this->hotelRepo->findAll();
        

        return $this->render('basic_hotel/index.html.twig', [
            'controller_name' => 'BasicHotelController',
            'hotelArray'=>$hotels,
            //'directorArray'=>$director
            //'roomArray' =>$room //Si creamos una habitacion aqui esto lo quitamos
        ]);
    }
}
