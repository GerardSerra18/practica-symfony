<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Form\ProviderType;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProviderController extends AbstractController
{
    /**
     * @Route("/providers", name="provider_index", methods={"GET"})
    */
    public function index(ProviderRepository $providerRepository): Response
    {
        $providers = $providerRepository->findAllProviders();

        

        return $this->render('provider/index.html.twig', [
            'providers' => $providers,
        ]);
    }

    /**
     * @Route("/providers/new", name="provider_new", methods={"GET", "POST"})
    */
    public function new(Request $request): Response
    {
        $provider = new Provider();
        $form = $this->createForm(ProviderType::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($provider);
            $entityManager->flush();

            return $this->redirectToRoute('provider_index');
        }

        return $this->render('provider/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/providers/{id}/edit", name="provider_edit", methods={"GET", "POST"})
    */
    public function edit(Request $request, Provider $provider): Response
    {
        $form = $this->createForm(ProviderType::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('provider_index');
        }

        return $this->render('provider/edit.html.twig', [
            'provider' => $provider,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/providers/{id}", name="provider_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Provider $provider): Response
    {
        if ($this->isCsrfTokenValid('delete'.$provider->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($provider);
            $entityManager->flush();
        }

        return $this->redirectToRoute('provider_index');
    }
}
