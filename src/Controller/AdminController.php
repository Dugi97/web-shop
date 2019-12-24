<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Colour;
use App\Entity\Gender;
use App\Entity\Material;
use App\Entity\Newsletter;
use App\Entity\Product;
use App\Entity\Size;
use App\Entity\SubCategory;
use App\Form\BrandType;
use App\Form\CategoryType;
use App\Form\ColourType;
use App\Form\GenderType;
use App\Form\MaterialType;
use App\Form\ProductType;
use App\Form\SizeType;
use App\Form\SubCategoryType;
use App\Model\iHelper;
use App\Services\Helper;
use App\Services\Mail;
use App\Services\Upload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(EntityManagerInterface $em)
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/settings", name="settings")
     */
    public function settings(EntityManagerInterface $em)
    {
        return $this->render('admin/settings.html.twig');
    }

    /**
     * @Route("/admin/add/product", name="add_product")
     */
    public function addProduct(Request $request, EntityManagerInterface $em, Upload $upload)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($upload->multiUpload($_FILES, strtolower($form['category']->getData()->getName())) == 'error') {
                $this->addFlash('error', 'One or more images are larger size... Please, add again...');
                return $this->redirectToRoute('add_product');
            }

            $size = [];
            $qty = [];
            foreach ($_POST as $index => $s) {
                if (strpos($index, 'size') !== false) {
                    $size[] = $s;
                } elseif (strpos($index, 'qty') !== false) {
                    $qty[] = $s;
                }
            }

            $product->setGender($form['gender']->getData()->getName());
            $product->setCategory($form['category']->getData()->getName());
            $product->setSubCategory($_POST['subCategory']);
            $product->setColour($form['colour']->getData()->getName());
            $product->setSize(array_combine($size, $qty));
            $product->setBrand($form['brand']->getData()->getName());
            $product->setMaterial($form['material']->getData()->getName());
            $product->setImages($upload->multiUpload($_FILES, strtolower($form['category']->getData()->getName())));
            $product->setSku(Helper::skuCode());
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Successfully add a product');

            return $this->redirectToRoute('add_product');
        }

        if ($request->isXmlHttpRequest()) {
            $id = $request->request->get('id');

            $option_tpl = $this->render('admin/ajax_templates/options.html.twig',
                [
                    'options' => $em->getRepository(SubCategory::class)->findByCriteria($id),
                ]
            );

            return new JsonResponse([
                'option' =>$option_tpl->getContent()
            ]);
        }

        return $this->render('admin/add_product.html.twig',
            [
                'form' => $form->createView(),
                'sizes' => $em->getRepository(Size::class)->findAll(),
                'error' => false
            ]
        );
    }

    /**
     * @Route("/admin/structure", name="structure")
     */
    public function structure(Request $request, EntityManagerInterface $em)
    {
        $gender = new Gender();
        $colour = new Colour();
        $category = new Category();
        $subCat = new SubCategory();
        $brand = new Brand();
        $size = new Size();
        $material = new Material();

        $fGender = $this->createForm(GenderType::class, $gender);
        $fColour = $this->createForm(ColourType::class, $colour);
        $fCategory = $this->createForm(CategoryType::class, $category);
        $fSubCat = $this->createForm(SubCategoryType::class, $subCat);
        $fBrand = $this->createForm(BrandType::class, $brand);
        $fSize = $this->createForm(SizeType::class, $size);
        $fMaterial = $this->createForm(MaterialType::class, $material);

        $fGender->handleRequest($request);
        $fColour->handleRequest($request);
        $fCategory->handleRequest($request);
        $fSubCat->handleRequest($request);
        $fBrand->handleRequest($request);
        $fSize->handleRequest($request);
        $fMaterial->handleRequest($request);

        if ($fGender->isSubmitted()) {
            $em->persist($gender);
            $em->flush();
            return $this->redirectToRoute('structure');
        }

        if ($fColour->isSubmitted()) {
            $em->persist($colour);
            $em->flush();
            return $this->redirectToRoute('structure');
        }

        if ($fCategory->isSubmitted()) {
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('structure');
        }

        if ($fSubCat->isSubmitted()) {
            $em->persist($subCat);
            $em->flush();
            return $this->redirectToRoute('structure');
        }

        if ($fBrand->isSubmitted()) {
            $em->persist($brand);
            $em->flush();
            return $this->redirectToRoute('structure');
        }

        if ($fSize->isSubmitted()) {
            $em->persist($size);
            $em->flush();
            return $this->redirectToRoute('structure');
        }

        if ($fMaterial->isSubmitted()) {
            $em->persist($material);
            $em->flush();
            return $this->redirectToRoute('structure');
        }

        return $this->render('admin/structure.html.twig',
            [
                'fGender' => $fGender->createView(),
                'fColour' => $fColour->createView(),
                'fCategory' => $fCategory->createView(),
                'fSubCat' => $fSubCat->createView(),
                'fBrand' => $fBrand->createView(),
                'fSize' => $fSize->createView(),
                'fMaterial' => $fMaterial->createView(),
                'emptyCat' => empty($em->getRepository(Category::class)->findAll()),
                'emptySubCat' => empty($em->getRepository(SubCategory::class)->findAll())
            ]
        );
    }

    /**
     * @Route("/admin/newsletter", name="newsletter")
     */
    public function newsletter(EntityManagerInterface $em, Mail $mail, iHelper $helper)
    {
        if (isset($_POST['submit'])) {
            $template = $_POST['temp'];
            $message = $_POST['message'];
            $title = $_POST['title'];

            if (isset($_POST['discount'])) {
                $disconut = $_POST['discount'];
            }
            if (isset($_POST['new_product'])) {
                $newProduct = $_POST['new_product'];
            }

            foreach ($em->getRepository(Newsletter::class)->findBy(['active' => true]) as $user) {
                $coupon = $helper::randomCode();

                $user->setCoupon($coupon);
                $user->setIsCouponUsed(false);
                $em->persist($user);
                $em->flush();
                $mail->sendMail($user->getEmail(), 'Newsletter', $this->renderView('emails/subscribers/' . $template . '.html.twig',
                    [
                        'template' => $template,
                        'coupon' => $coupon,
                        'message' => $message,
                        'email' => $user->getEmail(),
                        'title' => $title,
                        'discount_products' => isset($disconut) ? $em->getRepository(Product::class)->findByDiscountAndDate() : null,
                        'new_products' => isset($newProduct) ? $em->getRepository(Product::class)->findByDate() : null
                    ]
                ));
            }

            $this->addFlash('success', 'You have sent a newsletter to all subscribers');

//            return $this->redirectToRoute('newsletter');
        }

        return $this->render('admin/newsletter.html.twig');
    }

    /**
     * @Route("/newsletter/unsubscribe", name="unsubscribe")
     */
    public function unsubscribe(Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(Newsletter::class)->findOneBy(['email' => $request->query->get('email')]);
        $user->setActive(false);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('unsubscribe_info');
    }

    /**
     * @Route("/info", name="unsubscribe_info")
     */
    public function info()
    {
        return $this->render('admin/info.html.twig');
    }
}