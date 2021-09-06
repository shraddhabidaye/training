<?php

/**
 * @file
 * Contains Drupal\demo_restapi\Plugin\rest\resource\DemoPost.
 */

namespace Drupal\demo_restapi\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Psr\Log\LoggerInterface;

/**
 * Provides a resource to demonstrate post restapi.
 *
 * @RestResource(
 *   id = "demo_Postapi",
 *   label = @Translation("Demo Post rest resource"),
 *   uri_paths = {
 *     "create" = "/api/demo_post"
 *   }
 * )
 */
 class DemoPost extends ResourceBase
 {
  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a Drupal\rest\Plugin\ResourceBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   A current user instance.
   */
  public function __construct(
   array $configuration,
   $plugin_id,
   $plugin_definition,
   array $serializer_formats,
   LoggerInterface $logger,
   AccountProxyInterface($current_user)
   {
     parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);

     $this->currentUser = $current_user;
   }

   /**
    * {@inheritdoc}
    */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
      return new static
      (
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->getParameter('serializer.formats'),
        $container->get('logger.factory')->get($plugin_id),
        $container->get('current_user')
      );
    }

    /**
     * Responds to POST requests.
     *
     * Returns a mesage using post restapi.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function post($data)
    {
      \Drupal::logger('demo_restapi')->debug('<pre>' . print_r($data, TRUE) . '</pre>');
      if(!$this->currentUser->hasPermission($permission))
      {
        throw new AccessDeniedHttpException();
      }

      $data = ['message' => 'Hello, this is a rest service and parameter is: '.$data['name'] .' & ' .$data['email']];

      $response = new ResourceResponse($data);
      // In order to generate fresh result every time (without clearing
      // the cache), you need to invalidate the cache.
      $response->addCacheableDependency($data);
      return $response;

    }

 }
