<?php

namespace Drupal\request_form\Form;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class EmailSettings extends ConfigFormBase{

	const SETTINGS = 'request_form.email';

	public function getFormId(){
		return 'email_settings_form';
	}

	protected function getEditableConfigNames(){

		return[
			static::SETTINGS,
		];
	}

	public function buildForm(array $form, FormStateInterface $form_state){

		$config = $this->config(static::SETTINGS);

		$form['email_setting'] = [
			'#type' => 'email',
			'#title' => $this->t('Enter e-mail'),
			'#description' => 'Enter e-mail for getting mails from request form',
			'#default_value' => $config->get('email_setting'),
		];

		return parent::buildForm($form, $form_state);
	}

	public function validateForm(array &$form, FormStateInterface $form_state){

		if(!filter_var($form_state->getValue('email_setting'), FILTER_VALIDATE_EMAIL)){
			$form_state->setErrorByName('email_setting', $this->t('Enter valid email'));
		}
	}

	public function submitForm(array &$form, FormStateInterface $form_state){
		$this->configFactory->getEditable(static::SETTINGS)->set('email_setting', $form_state->getValue('email_setting'))->save();

		parent::submitForm($form, $form_state);
	}
}