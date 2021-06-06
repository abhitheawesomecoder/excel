<?php

namespace Modules\Settings\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class PasswordSettingsForm extends Form
{
    public function buildForm()
    {
    	$this->add('password', 'password',['rules' => 'required|confirmed|min:8']);

    	$this->add('password_confirmation', 'password');

        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
