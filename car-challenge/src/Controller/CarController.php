<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/", name="car_")
 */
class CarController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(CarRepository $CarRepository): Response
    {
        $cars = $CarRepository->findAllWithRelations();

        if ($cars === null) {
            throw $this->createNotFoundException('Cette voiture n\'existe pas');
        }

        return $this->render('car/browse.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"})
     */
    public function read(int $id, CarRepository $CarRepository): Response
    {
        $car = $CarRepository->findWithRelations($id);

        if ($car === null) {
            throw $this->createNotFoundException('Cette voiture n\'existe pas');
        }

        return $this->render('car/read.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route("add", name="add")
     */
    public function add(Request $request): Response
    {
        $car = new Car();

        $form = $this->createForm(CarType::class, $car);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            // On redirige sur la liste des Genre
            return $this->redirectToRoute('car_browse');
        }

        return $this->render('car/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function edit(Car $car, Request $request): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_browse');
        }

        return $this->render('car/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("delete/{id}", name="delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Car $car, Request $request)
    {
        $token = $request->request->get('_token');
        if ($this->isCsrfTokenValid('deleteCar' . $car->getId(), $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($car);
            $em->flush();

            return $this->redirectToRoute('car_browse');
        }

        throw $this->createAccessDeniedException('Le token n\'est pas valide.');
    }
}
