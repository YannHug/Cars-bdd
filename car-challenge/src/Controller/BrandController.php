<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/brand", name="brand_")
 */
class BrandController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(BrandRepository $brandRepository): Response
    {
        return $this->render('brand/browse.html.twig', [
            'brands' => $brandRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"})
     */
    public function read(Brand $brand): Response
    {
        return $this->render('brand/read.html.twig', [
            'brand' => $brand,
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        $brand = new Brand();

        $form = $this->createForm(BrandType::class, $brand);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brand);
            $em->flush();

            // On redirige sur la liste des Genre
            return $this->redirectToRoute('brand_browse');
        }

        return $this->render('brand/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}