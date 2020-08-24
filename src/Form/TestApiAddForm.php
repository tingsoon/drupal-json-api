<?php

namespace Drupal\testapi\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

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
      '#type' => 'textfield',
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

  public function redirectDashboard(array &$form, FormStateInterface $form_state, $id = null) {
    // return to main form
    $form_state->setRedirect('testapi.testapiform');
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
  }

}
