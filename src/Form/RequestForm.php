<?php

namespace Drupal\request_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

class RequestForm extends FormBase {

	public function getFormId(){
		return 'request_form';
	}

	public function buildForm(array $form, FormStateInterface $form_state){

		$user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
		$name = $user->field_first_name->value;
		$email = $user->getEmail();

		//global $user;
 		//$user_fields = user_load($user->uid);
 		//$name = $user_fields->field_first_name['und']['0']['value'];

		$form['name'] = [
			'#type' => 'textfield',
			'#title' => t('Your Name'),
			'#description' => t('Please enter your name'),
			'#required' => TRUE,
			'#default_value' => $name];

		$form['organization'] = [
			'#type' => 'textfield',
			'#title' => t('Your organization'),
			'#description' => t('Please enter your Organization name')];

		$form['employees'] = [
			'#title' => 'Count of employees',
			'#type' => 'select',
			'#options' => [
				0 => '10',
				1 => '20',
				2 => '<20',]
			];

		$form['city'] = [
			'#title' => 'Your City',
			'#type' => 'textfield',
			'#description' => 'Please enter your City'];

		$form['contact'] = [
			'#type' => 'fieldset',
			'#title' => 'Contact information',];

		$form['contact']['phone'] = [
			'#title' => 'Phone',
			'#type' => 'tel',
			'#description' => 'Please enter your Phone number',
			'#required' => TRUE,];

		$form['contact']['email'] = [
			'#title' => 'E-mail',
			'#type' => 'textfield',
			'#description' => 'Please enter your e-mail',
			'#default_value' => $email];

		$form['submit'] = [
			'#type' => 'submit',
			'#value' => t('Submit')];

		return $form;
	}

	public function validateForm(array &$form, FormStateInterface $form_state){

		if(strlen($form_state->getValue('name')) < 3){
		$form_state->setErrorByName('name', $this->t('Username must be at least 3 characters.'));
		}

		if(!$this->validate_phone_number($form_state->getValue('phone'))){
			$form_state->setErrorByName('phone', $this->t('Enter valid phone number'));
		}

		if(!filter_var($form_state->getValue('email_setting'), FILTER_VALIDATE_EMAIL)){
			$form_state->setErrorByName('email_setting', $this->t('Enter valid email'));
		}
	}

	public function submitForm(array &$form, FormStateInterface $form_state){

		if(!$this->send_mail()) {
			drupal_set_message(t('No mail has been sent'));
		}
		else drupal_set_message(t('Mail has been sent'));

	}

	public function validate_phone_number($phone){

		$filtered_phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
		$numbers = str_replace(['-', '+'], '', $filtered_phone);
		if(strlen($numbers)<7 || strlen($numbers)>12){
			return false;
		}
		return true;
	}

	public function send_mail(){

		$config = $this->config('request_form.email');
		$mail = $config->get('email_setting');
		$mailManager = \Drupal::service('plugin.manager.mail');
		$module = 'request_form';
		$key = 'submit';
		$to = $mail;
		$params['message'] = 'New Get Started query';
		$langcode = 'en';
		$send = true;
		$result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);

		if($result['result'] == true) {
			return true;
		}
		else return false;
	}
}
