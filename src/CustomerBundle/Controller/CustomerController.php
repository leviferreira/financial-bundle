<?php

namespace CustomerBundle\Controller;

use CustomerBundle\Form\CustomerType;
use CustomerBundle\Form\AddressType;

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

    }
}
