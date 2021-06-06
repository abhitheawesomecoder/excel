<?php

namespace Modules\Settings\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class UserSettingsForm extends Form
{
    public function buildForm()
    {
    	//$this->add('profile_photo', 'text');
    	$this->add('s_display_logo_upload', 'file', [
            'label' => 'Profile photo',
        ]);

    	$this->add('first_name', 'text');

    	$this->add('last_name', 'text');

    	$this->add('phone_number', 'text');

    	$this->add('email_address', 'text',['rules' => 'required']);

        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
