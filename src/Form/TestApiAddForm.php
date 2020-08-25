<?php

namespace Drupal\testapi\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class TestApiAddForm extends FormBase {

  public function getFormId() {
    // TODO: Implement getFormId() method.
    return test_api_delete_form;
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    // TODO: Implement buildForm() method.
    $form['description_add'] = [
      '#type' => 'item',
      '#markup' => $this->t('This is the form to add.'),
    ];

    $form['userId_add'] = [
      '#type' => 'number',
      '#title' => $this->t('User ID'),
    ];

    $form['id_add'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ID'),
    ];

    $form['title_add'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#submit' => array([$this, 'addID']),
    ];

    // Add a back button
    $form['actions']['back'] = [
      '#type' => 'submit',
      '#value' => $this->t('Back'),
      '#submit' => array([$this, 'redirectDashboard']),
    ];

    return $form;
  }

  // Adding custom validations
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $form_userId = $form_state->getValue('userId_add');
    $form_id = $form_state->getValue('id_add');
    $form_title = $form_state->getValue('title_add');
    $continue = TRUE;

    if ($form_userId < 0) {
      $form_state->setErrorByName('userId_add', $this->t('Must be numeric and value > 0.'));
      $continue = FALSE;
    }

    if (!preg_match("/[A-Z][0-9]/",$form_id) && !empty($form_id)) {
      $form_state->setErrorByName('id_add', $this->t('Must be at least one Uppercase letter followed by at least one number.'));
      $continue = FALSE;
    }

  }

  public function redirectDashboard(array &$form, FormStateInterface $form_state, $id = null) {
    // return to main form
    $form_state->setRedirect('testapi.testapiform');
  }

  public function addID(array &$form, FormStateInterface $form_state, $id = null) {
    // Adding post request to API
    $newUserId = $form_state->getValue('userId_add');
    $newId = $form_state->getValue('id_add');
    $newTitle = $form_state->getValue('title_add');

//    drupal_set_message($newUserId);
//    drupal_set_message($newId);
//    drupal_set_message($newTitle);

    $body = array(
      "userId" => $newUserId,
      "id" => $newId,
      "title" => $newTitle,
      "completed" => false,
    );

//    drupal_set_message(json_encode($body));

    $clientAdd = \Drupal::httpClient();
    $addUrl = 'https://jsonplaceholder.typicode.com/todos/';

    try {
      $responseAdd = $clientAdd->post($addUrl, $body);
      $statusCodeAdd = $responseAdd->getStatusCode();
    } catch (RequestException $e) {
//      return new Response($e->getMessage());
      drupal_set_message($e->getMessage(), 'error');
    }

    drupal_set_message($statusCodeAdd);

    if ($statusCodeAdd == '201') {
      drupal_set_message(t('ID %id is Added.', ['%id' => $newId]));
    } else {
      drupal_set_message(t('Status Code is NOT 201. Refer to error logs.'), 'error');
    }

    // return to main form
    $form_state->setRedirect('testapi.testapiform');
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
  }

}
