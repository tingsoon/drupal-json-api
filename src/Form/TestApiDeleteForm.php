<?php

namespace Drupal\testapi\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class TestApiDeleteForm extends FormBase {

  public function buildForm(array $form, FormStateInterface $form_state, $id = null) {
    // Calling api to retrieve the individual values
    $client = \Drupal::httpClient();
    $url = 'https://jsonplaceholder.typicode.com/todos/'.$id;
    $request = $client->get($url);
    $response = $request->getBody()->getContents();
    $data = json_decode($response);

    // TODO: Implement buildForm() method.
    $form['description_delete'] = [
      '#type' => 'item',
      '#markup' => $this->t('Are you sure you want to delete ID : %id ?', ['%id' => $id]),
    ];

    $form['userId_del'] = [
      '#type' => 'textfield',
      '#default_value' => $this->t(strval($data->userId)),
      '#title' => $this->t('User ID'),
      '#disabled' => TRUE,
    ];

    $form['id_del'] = [
      '#type' => 'textfield',
      '#default_value' => $this->t(strval($data->id)),
      '#title' => $this->t('ID'),
      '#disabled' => TRUE,
    ];

    $form['title_del'] = [
      '#type' => 'textfield',
      '#default_value' => $this->t($data->title),
      '#title' => $this->t('Title'),
      '#disabled' => TRUE,
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#submit' => array([$this, 'removeID']),
    ];

    // Add a back button
    $form['actions']['back'] = [
      '#type' => 'submit',
      '#value' => $this->t('Back'),
      '#submit' => array([$this, 'redirectDashboard']),
    ];

    return $form;

  }

  public function getFormId() {
    // TODO: Implement getFormId() method.
    return test_api_delete_form;
  }

  public function removeID(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
    $id = $form_state->getValue('id');
//    drupal_set_message(t('ID %id is deleted.', ['%id' => $id]));

    // Api delete request
    $clientDelete = \Drupal::httpClient();
    $delUrl = 'https://jsonplaceholder.typicode.com/todos/'.$id;
    drupal_set_message(t('ID %delUrl ', ['%delUrl' => $delUrl]));

    try {
      $responseDelete = $clientDelete->delete($delUrl);
      $statusCodeDelete = $responseDelete->getStatusCode();
      drupal_set_message(t('Status Code %statusCodeDelete ', ['%statusCodeDelete' => $statusCodeDelete]));
    } catch (RequestException $e) {
      drupal_set_message($e->getMessage(), 'error');
    }

    if ($statusCodeDelete == '200') {
//      drupal_set_message(t('Status Code is 200'), 'status');
      drupal_set_message(t('ID %id is deleted.', ['%id' => $id]));
    } else {
      drupal_set_message(t('Status Code is NOT 200. Refer to error logs.'), 'error');
    }

    // return to main form
    $form_state->setRedirect('testapi.testapiform');

  }

  public function redirectDashboard(array &$form, FormStateInterface $form_state, $id = null) {
    // return to main form
    $form_state->setRedirect('testapi.testapiform');
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
  }

}
