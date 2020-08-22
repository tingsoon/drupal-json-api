<?php

namespace Drupal\testapi\Controller;

use Symfony\Component\HttpFoundation\Response;

class TestController {

  public function build() {

    // Create a client with a base URI
    $client = \Drupal::httpClient();
    $request = $client->get('https://jsonplaceholder.typicode.com/todos/1');
    $response = $request->getBody()->getContents();

//    drupal_set_message($response);

    return new Response($response);
  }
}
