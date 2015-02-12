<?php
namespace TaskManagerBundle\Form; 

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType{ 
	

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('title','text',[
					'label' => 'Title',
					'attr' => ['class' => 'form-control']
			])
			->add('completed','choice',[
					'choices' => ['0' => 'Not Completed', '1' => 'Completed'],
					'label' => 'Completed',
					'attr' => ['class' => 'form-control']
					
			])
			->add('due_date','date',[ 
					'label' => 'Due Date', 
					'widget' => 'single_text',
					'attr' => ['class' => 'form-control']
			]);
			
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'TaskManagerBundle\Entity\Projects'
		));
	}
	
	public function getName()
	{
		return 'testbundle_projects';
	}

}