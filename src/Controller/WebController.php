<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Gender;
use App\Entity\Newsletter;
use App\Entity\Product;
use App\Entity\SubCategory;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebController extends Controller
{
    /**
     * @Route("/", name="home")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(EntityManagerInterface $em)
    {
        return $this->render('default/index.html.twig',
            [
                'recommended' => $em->getRepository(Product::class)->findByDiscount()
            ]
        );
    }

    /**
     * @Route("/product", name="product")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function products(Request $request, EntityManagerInterface $em)
    {
        $category = $request->query->get('category');
        $gender = $request->query->get('gender');
        $page = (int)$request->query->get('page');
        $subCategory = $request->query->get('subCategory');
        $size = $request->query->get('size');
        $price = $request->query->get('price') ? explode(',', $request->query->get('price')) : [10,100000];

        $limit = 9;
        $pagination = count($em->getRepository(Product::class)->findAllByCriteria($gender, $category, $subCategory, $size, $price));

        $products = [];
        $title = 'all products';
        if (!empty($request->query->all())) {
            $title = strtolower( $category . ' for ' . $gender);
            $products = $em->getRepository(Product::class)->findProducts($gender, $category, $page, $limit, $subCategory, $size, $price);
        }

        return $this->render('default/products.html.twig',
            [
                'products' => $products,
                'headline' => $title,
                'pagination' => ceil($pagination/$limit),
                'gender' => $gender,
                'size' => $size,
                'price' => implode(',', $price),
                'category' => $category,
                'subCategory' => $subCategory,
                'subCategories' => $em->getRepository(SubCategory::class)->findByCategory($category),
                'test' => $pagination
            ]
        );
    }

    /**
     * @Route("/view/content/{id}", name="view_content")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Product $product
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function viewProduct(Request $request,EntityManagerInterface $em, Product $product, $id)
    {
        $response = new Response();

        if (isset($_POST['btn-qty'])) {
            $cookie = [
                'product' => $product,
                'qty' => $_POST['qty']
            ];

            $response->headers->setCookie(new Cookie("product-${id}", serialize($cookie)));
            $response->send();

            return $this->redirectToRoute('view_content', ['id' => $id]);
        }

        return $this->render('default/view.html.twig',
            [
                'product' => $product
            ]
        );
    }

    /**
     * @Route("/checkout", name="checkout")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function checkout(EntityManagerInterface $em, Request $request)
    {
        $products = [];
        foreach ($request->cookies->all() as $index => $c) {
            if (\strpos($index, 'product') !== false) {
                $products[$index] = unserialize($c);
            }
        }

        return $this->render('default/checkout.html.twig',
            [
                'products' => $products
            ]
        );
    }

    /**
     * @Route("/newsletter", name="apply_newsletter")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newsletter(EntityManagerInterface $em)
    {
        $newsletter = new Newsletter();

        if (isset($_POST['submit'])) {
            $newsletter->setEmail($_POST['email']);
            $em->persist($newsletter);
            $em->flush();

            $this->addFlash('success', 'You have applied for a newsletter.');
            return $this->redirectToRoute("home");
        }
    }

    /**
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function renderMenu(EntityManagerInterface $em)
    {
        return $this->render('default/parts/menu/menu.html.twig',
            [
                'gender' => $em->getRepository(Gender::class)->findAll(),
                'categories' => $em->getRepository(Category::class)->findAll(),
                'sub_categories' => $em->getRepository(SubCategory::class)->findAll()
            ]
        );
    }

    public function renderCart(Request $request)
    {
        $products = $request->cookies;

        return $this->render('default/parts/cart/cart.html.twig',
            [
                'isCart' => count($products) > 0 ? true : false
            ]
        );
    }
}
