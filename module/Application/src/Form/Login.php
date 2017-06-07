<?php 

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class Login extends Form {

  	public function __construct()
  	{

	    # Define form name
	    parent::__construct('login-form');

		# Set POST method for this form
	    $this->setAttribute('method', 'post');

		$this->addInputs();  	    
		$this->addFilters();	    

	}

	private function addInputs() {
	    # Add email input
	    $this->add([
	    	'type' => 'email',
	    	'name' => 'email',
	    	'options' => ['label' => 'Email'],
	    	'attributes' => ['class' => 'form-control'],
	    ]);


	    # Add password input
	    $this->add([
	    	'type' => 'password',
	    	'name' => 'password',
	    	'options' => ['label' => 'Password'],
	    	'attributes' => ['class' => 'form-control'],

	    ]);   

	    # Security token
        /*$this->add([
        	'type' => 'csrf',
        	'name' => 'security',
            'options' => [
            	'csrf_options' => ['timeout' => 60]
            ],        	
        ]);*/	

        $this->add([
            'type'  => 'captcha',
            'name' => 'captcha',
            'attributes' => [
            ],
            'options' => [
                'label' => 'Human check',
                'captcha' => [
                    'class' => 'Image',
                    'imgDir' => 'public/img/captcha',
                    'suffix' => '.png',
                    'imgUrl' => '/img/captcha/',
                    'imgAlt' => 'CAPTCHA Image',
                    'font'   => './data/font/thorne_shaded.ttf',
                    'fsize'  => 24,
                    'width'  => 350,
                    'height' => 130,
                    'expiration' => 120, 
                    'dotNoiseLevel' => 20,
                    'lineNoiseLevel' => 2
                ],
            ],
        ]);



	    # Add submit button
	    $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => 'Login',
                'class' => 'btn btn-primary btn-block',
            ],
        ]); 

	}


	private function addFilters() {
		$filter = new InputFilter();

		$filter->add([
			'name' => 'email',
			'required' => true,
			'filters' => [
				['name' => 'StringTrim']
			],
			'validators' => [
				[
					'name' => 'EmailAddress',
				]
			],
		]);

		$filter->add([
			'name'     => 'password',
			'required' => true,
			'filters'  => [
		       ['name' => 'StringTrim'],
		       ['name' => 'StripTags'],
		       ['name' => 'StripNewlines'],
		    ],                
		    'validators' => [
		       ['name' => 'StringLength',
					'options' => [
						'min' => 5,
			            'max' => 24
					],
				]
			],
		]);		

		$this->setInputFilter($filter);

	}


   	
}