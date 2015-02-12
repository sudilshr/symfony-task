<?php

namespace TaskManagerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use TaskManagerBundle\Entity\Projects;
use TaskManagerBundle\Form\ProjectType;


class DefaultController extends Controller
{
	
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$projects = $em->getRepository('TestBundle:Projects')->findAll();
    	
    	return $this->render('TestBundle:Default:index.html.twig', [
	    			'projects' => $projects,
    			]
    	);
    }
    
    public function createAction(Request $request)
    {
    	$entity = new Projects();
    	$form = $this->createCreateForm($entity);
    	$form->handleRequest($request);
    
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($entity);
    		$em->flush();
    
    		return $this->redirect($this->generateUrl('test_homepage', array('id' => $entity->getId())));
    	}
    
    	return $this->render('TestBundle:Default:new.html.twig', array(
    			'entity' => $entity,
    			'form'   => $form->createView(),
    	));
    }
    
    private function createCreateForm(Projects $entity)
    {
    	$form = $this->createForm(new ProjectType(), $entity, array(
    			'action' => $this->generateUrl('projects_create'),
    			'method' => 'POST',
    	));
    	
    	$form->add('Create Project','submit',[
    			'attr' => ['class' => 'btn btn-success']
    	]);
    
    	return $form;
    }
    
    
    public function newAction()
    { 
    	$entity = new Projects();
        $form   = $this->createCreateForm($entity);

        return $this->render('TestBundle:Default:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    public function editAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$entity = $em->getRepository('TestBundle:Projects')->find($id);
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find Projects entity.');
    	}
    
    	$editForm = $this->createEditForm($entity);
    
    	return $this->render('TestBundle:Default:edit.html.twig', array(
    			'entity'      => $entity,
    			'edit_form'   => $editForm->createView(),
    	));
    }
    
    private function createEditForm(Projects $entity)
    {
    	$form = $this->createForm(new ProjectType(), $entity, array(
    			'action' => $this->generateUrl('projects_update', array('id' => $entity->getId())),
    			'method' => 'PUT',
    	));
    
    	$form->add('Update Project','submit',[
					'attr' => ['class' => 'btn btn-success']
			]);
    
    	return $form;
    }
    
    public function updateAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$entity = $em->getRepository('TestBundle:Projects')->find($id);
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find Products entity.');
    	}
    
    	$editForm = $this->createEditForm($entity);
    	$editForm->handleRequest($request);
    
    	if ($editForm->isValid()) {
    		$em->flush();
    
    		return $this->redirect($this->generateUrl('projects_edit', array('id' => $id)));
    	}
    
    	return $this->render('TestBundle:Default:edit.html.twig', array(
    			'entity'      => $entity,
    			'edit_form'   => $editForm->createView(),
    	));
    }
    
    public function deleteAction(Request $request, $id)
    {
    	$form = $this->createDeleteForm($id);
    	$form->handleRequest($request);
    
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$entity = $em->getRepository('TestBundle:Projects')->find($id);
    
    		if (!$entity) {
    			throw $this->createNotFoundException('Unable to find Products entity.');
    		}
    
    		$em->remove($entity);
    		$em->flush();
    	}
    
    	return $this->redirect($this->generateUrl('test_homepage'));
    	
    }
    
    private function createDeleteForm($id)
    {
    	return $this->createFormBuilder()
    	->setAction($this->generateUrl('projects_delete', array('id' => $id)))
    	->setMethod('DELETE')
    	
    	->add('Delete','submit',[
    			'attr' => ['class' => 'btn btn-success']
    	])
    	->getForm();
    }
    
    
    
    public function testAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$projects = $em->getRepository('TestBundle:Projects')
    		->getNumberOfTasks(); 
    	
    	print_r($projects); 
    	exit();
    }
    
}
