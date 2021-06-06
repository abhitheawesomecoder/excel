<?php

namespace Modules\Settings\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class CompanySettingsForm extends Form
{
    public function buildForm()
    {
    	$this->add('company_name', 'text');

    	$this->add('address', 'textarea');

    	$this->add('city', 'text');

    	$this->add('state', 'text');

    	$this->add('post_code', 'text');

    	$this->add('country', 'text');

    	$this->add('phone', 'text');

    	$this->add('website', 'text');
        
    	$this->add('vat_id', 'text');

        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
