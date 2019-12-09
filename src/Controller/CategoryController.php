<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Form\AddCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Flex\Response;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->render('category/home.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category
        ]);
    }

    /**
     * @Route("/category/add", name="category_add")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $category = new Category();

        $form = $this->createForm(AddCategoryType::class,$category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('category_add');
        }

        return $this->render('category/add.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
