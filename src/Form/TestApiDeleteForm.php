<?php

namespace Drupal\testapi\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TestApiDeleteForm extends FormBase {

  public function buildForm(array $form, FormStateInterface $form_state, $id = null) {
    // TODO: Implement buildForm() method.
    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Are you sure you want to delete ID : %id ?', ['%id' => $id]),
    ];

    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#submit' => array([$this, 'removeID']),
      '#ajax' => [
        // The Ajax callback method that is responsible for responding to the
        // Ajax HTTP request.
        'callback' => '::deleteID',
      ],
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

  public function deleteID(array &$form, FormStateInterface $form_state) {
    // Ajax request to delete ID

  }

  public function removeID(array &$form, FormStateInterface $form_state, $id = null) {
    // TODO: Implement submitForm() method.
    drupal_set_message(t('ID %id is deleted.'));
  }

  public function redirectDashboard(array &$form, FormStateInterface $form_state, $id = null) {
    $form_state->setRedirect('testapi.testapiform');
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
  }

}
