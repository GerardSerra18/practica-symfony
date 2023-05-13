<?php

namespace App\Repository;

use App\Entity\Provider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

/**
 * Repository for the entity provider
 * This repository is to interact with providers in the db
 */

class ProviderRepository extends ServiceEntityRepository{

    /**
     * Inicializing the repository with the entity
     */
    public function __construct(ManagerRegistry $registry){
        parent::__construct($registry, Provider::class);
    }

    /**
     * Required functions
     * Create
     * Update
     * Delete
     * List all them
     */
    
    public function findAllProviders(){
        return $this->findAll();
    }

    public function createProvider(Provider $provider){


        $entityManager = $this->getEntityManager();
        $entityManager->persist($provider);
        $entityManager->flush();
    }

    public function updateProvider(Provider $provider){

        $entityManager = $this->getEntityManager();
        $entityManager->flush();
    }

    public function deleteProvider(Provider $provider){

        $entityManager = $this->getEntityManager();
        $entityManager->remove($provider);
        $entityManager->flush();
    }

    public function editProvider(Provider $provider, array $data): void
    {
        $provider->setProviderName($data['provider_name']);
        $provider->setEmail($data['email']);
        $provider->setPhone($data['phone']);
        $provider->setProviderType($data['provider_type']);
        $provider->setIsActive($data['isActive']);

        $entityManager = $this->getEntityManager();
        $entityManager->flush();
    }

}