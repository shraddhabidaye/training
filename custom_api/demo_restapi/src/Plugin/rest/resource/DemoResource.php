<?php

/**
 * @file
 * Contains Drupal\demo_restapi\Plugin\rest\resource\DemoResource.
 */


namespace Drupal\demo_restapi\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Provides a Demo GET Resource
 *
 * @RestResource(
 *   id = "demo_resource",
 *   label = @Translation("Demo Resource"),
 *   uri_paths = {
 *     "canonical" = "/demo_restapi/demo_resource"
 *   }
 * )
 */

class DemoResource extends ResourceBase
{
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
  public function get()
  {
    $response = ['message' => 'Hello, this is a rest service'];
    return new ResourceResponse($response);
  }
}
