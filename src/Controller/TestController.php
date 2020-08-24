<?php

namespace Drupal\testapi\Controller;

use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class TestController {

  public function build() {

//    // Create a client with a base URI
//    $client = \Drupal::httpClient();
//    $request = $client->get('https://jsonplaceholder.typicode.com/todos/1');
//    $response = $request->getBody()->getContents();
//
////    drupal_set_message($response);
//
//    return new Response($response);

    // test delete request
    $client = \Drupal::httpClient();
    $delUrl = 'https://jsonplaceholder.typicode.com/todos/1';

    try {
      $response = $client->delete($delUrl);
      $statusCode = $response->getStatusCode();
    } catch (RequestException $e) {
      return new Response($e->getMessage());
    }
      return new Response('Status Code: '.$statusCode);
  }
}
