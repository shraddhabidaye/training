<?php

/**
 * @file
 * Contains Drupal\demo_restapi\Plugin\rest\resource\CreateBlogResource.
 */

namespace Drupal\demo_restapi\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Psr\Log\LoggerInterface;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "create_blog",
 *   label = @Translation("Create blog rest api resource"),
 *   uri_paths = {
 *     "create" = "/api/createblog"
 *   }
 * )
 */
class CreateBlogResource extends ResourceBase
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
      AccountProxyInterface $current_user)
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
       * Returns a list of bundles for specified entity.
       *
       * @throws \Symfony\Component\HttpKernel\Exception\HttpException
       *   Throws exception expected.
         */
      public function post($data)
       {
            \Drupal::logger('demo_restapi')->debug('<pre>' . print_r($data, TRUE) . '</pre>');


            // You must to implement the logic of your REST Resource here.
            // Use current user after pass authentication to validate access.


            // if(!$this->currentUser->hasPermission($permission))
            // {
            //   throw new AccessDeniedHttpException();
            // }

              $node = \Drupal::entityTypeManager()->getStorage('node')->create([
              'type' => 'blog',
              'title' => $data['title'],
              'body' => $data['body'],
              'field_blog_category' =>  $data['category'],
            ]);

            $node->enforceIsNew(TRUE);
            $node->save();

            $entities = \Drupal::entityTypeManager()
              ->getStorage('node')
              ->loadByProperties(['type' => 'blog']);
            foreach ($entities as $entity)
            {
              $result[$entity->id()] = $entity->title->value;
            }

            $response = new ResourceResponse($result);
            $response->addCacheableDependency($result);

            return $response;

       }

 }
