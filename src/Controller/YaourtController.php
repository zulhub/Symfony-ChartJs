<?php

namespace App\Controller;

use App\Entity\Yaourt;
use App\Form\YaourtType;
use App\Repository\YaourtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/yaourt")
 */
class YaourtController extends AbstractController
{
    /**
     * @Route("/", name="app_yaourt_index", methods={"GET"})
     */
    public function index(YaourtRepository $yaourtRepository): Response
    {
        return $this->render('yaourt/index.html.twig', [
            'yaourts' => $yaourtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_yaourt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, YaourtRepository $yaourtRepository): Response
    {
        $yaourt = new Yaourt();
        $form = $this->createForm(YaourtType::class, $yaourt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yaourtRepository->add($yaourt);
            return $this->redirectToRoute('app_yaourt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('yaourt/new.html.twig', [
            'yaourt' => $yaourt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_yaourt_show", methods={"GET"})
     */
    public function show(Yaourt $yaourt): Response
    {
        return $this->render('yaourt/show.html.twig', [
            'yaourt' => $yaourt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_yaourt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Yaourt $yaourt, YaourtRepository $yaourtRepository): Response
    {
        $form = $this->createForm(YaourtType::class, $yaourt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yaourtRepository->add($yaourt);
            return $this->redirectToRoute('app_yaourt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('yaourt/edit.html.twig', [
            'yaourt' => $yaourt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_yaourt_delete", methods={"POST"})
     */
    public function delete(Request $request, Yaourt $yaourt, YaourtRepository $yaourtRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$yaourt->getId(), $request->request->get('_token'))) {
            $yaourtRepository->remove($yaourt);
        }

        return $this->redirectToRoute('app_yaourt_index', [], Response::HTTP_SEE_OTHER);
    }
}
