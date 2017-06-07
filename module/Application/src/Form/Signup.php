<?php 

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class Signup extends Form {

  	public function __construct()
  	{

	    # Define form name
	    parent::__construct('signup-form');

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

	    # Add username input
	    $this->add([
	    	'type' => 'text',
	    	'name' => 'username',
	    	'options' => ['label' => 'Username'],
	    	'attributes' => ['class' => 'form-control'],

	    ]);

	    # Add password input
	    $this->add([
	    	'type' => 'password',
	    	'name' => 'password',
	    	'options' => ['label' => 'Password'],
	    	'attributes' => ['class' => 'form-control'],

	    ]);

	    # Add pass repeat input
	    $this->add([
	    	'type' => 'password',
	    	'name' => 'password_repeat',
	    	'options' => ['label' => 'Repeat your password'],
	    	'attributes' => ['class' => 'form-control'],
	    ]);	    

	    # Security token
        // $this->add([
        // 	'type' => 'csrf',
        // 	'name' => 'security',
        //     'options' => [
        //     	'csrf_options' => ['timeout' => 60]
        //     ],        	
        // ]);	

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
                'value' => 'Signup',
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
			'name'     => 'username',
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
			            'max' => 18
					],
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

		$filter->add([
			'name'     => 'password_repeat',
			'required' => true,
			'filters'  => [
		       ['name' => 'StringTrim'],
		       ['name' => 'StripTags'],
		       ['name' => 'StripNewlines'],
		    ],                
		    'validators' => [
		       ['name' => 'StringLength', 'options' => [
					'min' => 5,
			        'max' => 24
				]],
				['name' => 'Identical', 'options' =>[
					'token' => 'password'
				]]
			],
		]);	
		$this->setInputFilter($filter);

	}


   	
}