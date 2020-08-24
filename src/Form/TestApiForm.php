<?php

namespace Drupal\testapi\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TestApiForm extends FormBase {

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $client = \Drupal::httpClient();
    $request = $client->get('https://jsonplaceholder.typicode.com/todos');
    $response = $request->getBody()->getContents();
    $data = json_decode($response);
//    drupal_set_message($response);
//    drupal_set_message($data->userId);
//    foreach($data as $key => $value) {
//      drupal_set_message($key);
//      drupal_set_message($value->id);
//    }

//    // TODO: Implement buildForm() method.
    $build['table'] = [
      '#type' => 'table',
      '#caption' => $this->t('Our favorite colors.'),
      '#header' => [t('UserID'), t('ID'), t('Title'), t('Delete')],
//      '#rows' => [
//        [$this->t(strval($data->userId)), $this->t(strval($data->id)), $this->t($data->title)],
//      ],
      '#description' => $this->t('Example of using #type.'),
    ];

    $rows = [];
    foreach($data as $key => $value) {
      // set delete URL
//      $delete_url = '<a href="https://jsonplaceholder.typicode.com/todos/'.$value->id.'" class="use-ajax" >Delete URL</a>';
      $delete_url = '<a href="/testapideleteform/'.$value->id.'" >Delete URL</a>';

      $rows[$key]['UserID'] = t(strval($value->userId));
      $rows[$key]['ID'] = t(strval($value->id));
      $rows[$key]['Title'] = t(strval($value->title));
      $rows[$key]['delete'] = ['data' => [
        '#markup' => $delete_url,
        '#extra' => $value->id, // store id for later.
      ]];
//      drupal_set_message($key);
    }

    $build['table']['#rows'] = $rows;

    return $build;
  }

  public function getFormId()
  {
    // TODO: Implement getFormId() method.
    return 'test_api_form';
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
  }
}
