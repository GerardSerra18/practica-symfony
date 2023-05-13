<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Provider;
use App\Form\ProviderType;
use App\Repository\ProviderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
    public function new(Request $request, ProviderRepository $providerRepository): Response
    {
        $provider = new Provider();
        $form = $this->createForm(ProviderType::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $providerRepository->createProvider($provider);

            return $this->redirectToRoute('provider_index');
        }   

        return $this->render('provider/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
    * @Route("/providers/{id}/edit", name="provider_edit", methods={"GET", "POST"})
    */
    public function edit(Request $request, Provider $provider, ProviderRepository $providerRepository): Response
    {
        $form = $this->createForm(ProviderType::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = [
                'provider_name' => $form->get('provider_name')->getData(),
                'email' => $form->get('email')->getData(),
                'phone' => $form->get('phone')->getData(),
                'provider_type' => $form->get('provider_type')->getData(),
                'isActive' => $form->get('isActive')->getData(),
            ];

            $providerRepository->editProvider($provider, $data);

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
    public function delete(Request $request, Provider $provider, ProviderRepository $providerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$provider->getId(), $request->request->get('_token'))) {
            $providerRepository->deleteProvider($provider);
        }

        return $this->redirectToRoute('provider_index');
    }

}
