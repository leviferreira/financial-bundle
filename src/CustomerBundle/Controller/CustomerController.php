<?php

namespace CustomerBundle\Controller;

use CustomerBundle\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends Controller
{
    public function listAction()
    {
        $entityManager = $this->get('doctrine')->getManager();

        $customers = $entityManager
            ->getRepository('CustomerBundle:Customer')
            ->findAll();

        return $this->render(
            'CustomerBundle:Customer:list.html.twig', [
                'customers' => $customers,
            ]
        );
    }

    public function newAction()
    {
        $form = $this->createForm(new CustomerType());

        return $this->render(
            'CustomerBundle:Customer:new.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function createAction()
    {
        $request = $this->getRequest();

        $form = $this->createForm(new CustomerType());
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render('CustomerBundle:Customer:new.html.twig', [
                'form' => $form->createView()
            ]);
        }

        $customer = $form->getData();
        $em = $this->get('doctrine')->getManager();

        $em->persist($customer);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Created successfully!');

        return $this->redirect($this->generateUrl('customer_list'));
    }

    public function viewAction($id)
    {
        $customer = $this->getDoctrine()->getRepository('CustomerBundle:Customer')->findOneById($id);

        if (!$customer) {
            throw new \InvalidArgumentException('Customer not found');
        }

        return $this->render('CustomerBundle:customer:view.html.twig', [
            'customer' => $customer,
        ]);
    }

    public function editAction($id)
    {
        try {
            $customer = $this->getDoctrine()->getRepository('CustomerBundle:Customer')->findOneById($id);

            if (!$customer) {
                throw new \InvalidArgumentException('Customer not found');
            }

            $form = $this->createForm(new CustomerType(), $customer);

            return $this->render('CustomerBundle:customer:edit.html.twig', [
                'form' => $form->createView(),
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->add('error', $e->getMessage());
            $this->get('logger')->err($e->getMessage());
            return $this->redirect($this->generateUrl('customer_list'));
        }
    }

    public function updateAction($id)
    {
        $request = $this->getRequest();

        $form = $this->createForm(new CustomerType());
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render('CustomerBundle:Customer:edit.html.twig', [
                'form' => $form->createView(),
                'id' => $id,
            ]);
        }

        $customer = $form->getData();
        $customer->setId($id);
        $em = $this->get('doctrine')->getManager();

        $em->merge($customer);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Updated successfully!');

        return $this->redirect($this->generateUrl('customer_list'));
    }

    public function deleteAction($id)
    {
        $customer = $this->getDoctrine()->getRepository('CustomerBundle:Customer')->findOneById($id);

        if (!$customer) {
            throw new \InvalidArgumentException('Customer not found');
        }

        $em = $this->get('doctrine')->getManager();
        $em->remove($customer);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Deleted successfully!');

        return $this->redirect($this->generateUrl('customer_list'));
    }
}
