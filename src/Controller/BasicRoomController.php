<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Room;
use App\Repository\HotelRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasicRoomController extends AbstractController
{
    public function __construct(private RoomRepository $roomRepo, private HotelRepository $hotelRepo)
    {
        
    }
    #[Route('/basic/room', name: 'app_basic_room')]
    public function index(): Response
    {
        $room1 = new Room();
        $room1->setNRoom(1);
        $room1->setFloor(1);
        $room1->setOrientation('Norte');

        /*$hotel1 = new Hotel();
        $hotel1->setName('Melia');
        $hotel1->setCity('Alicante');
        $hotel1->setNRooms(50);
        $hotel1->setAddress('Puerto Alicante');*/

        $hotel = $this->hotelRepo->find(1);// en Array hotel pillamos el hotel 1.

        $room1->setHotelId($hotel);// pilla el ID del hotel 1  y se lo pasa a la habitacion 1

        $this->roomRepo->save($room1, true);// graba la habitacion con todo y el ID del hotel 1

        // CREAMOS OTRA HABITACION
        $room2 = new Room();
        $room2->setNRoom(2);
        $room2->setFloor(1);
        $room2->setOrientation('Sur');
        
        $hotel = $this->hotelRepo->find(2);

        $room2->setHotelId($hotel);

        $this->roomRepo->save($room2, true);
    
        $rooms = $this->roomRepo->findAll();

        return $this->render('basic_room/index.html.twig', [
            'controller_name' => 'BasicRoomController',
            'roomArray'=>$rooms,
            'hotelArray'=>$hotel // si creamos hotel aqui este array no va
        ]);
    }
}
