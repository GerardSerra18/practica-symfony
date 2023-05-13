<?php

namespace App\Repository;

use App\Entity\Provider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

        $provider->setIsActive(true); // Establecer isActive como verdadero por defecto

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

}