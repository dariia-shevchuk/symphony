<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $repository
     * @return Response
     */
    #[Route('/products')]
    public function show(EntityManagerInterface $entityManager, ProductRepository $repository): Response
    {
        //Method 1
        $products = $entityManager->getRepository(Product::class)->findAll();

        //Method 2
        $products = $repository->findAll();

        foreach ($products as $product) {
            var_dump($product);
        }

        return $this->render('products/products.html.twig', []);
    }


    /**
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $repository
     * @return Response
     */
    #[Route('/product/{id}')]
    public function showById(ProductRepository $repository, int $id): Response
    {
        $product = $repository->find($id);

        return $this->render('products/product.html.twig', [
            'product' => $product
        ]);
    }
}