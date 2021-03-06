<?php

/**
 * @file
 * Contains Drupal\blog_list\Plugin\rest\resource\BlogListResource.
 */

namespace Drupal\blog_list\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Psr\Log\LoggerInterface;

/**
 * Provides a resource to get list by Blogs.
 *
 * @RestResource(
 *   id = "bloglist_resource",
 *   label = @Translation("Bloglist rest resource"),
 *   uri_paths = {
 *     "canonical" = "/api/blog_list"
 *   }
 * )
 */

 class BlogListResource extends ResourceBase
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
     return new static(
       $configuration,
       $plugin_id,
       $plugin_definition,
       $container->getParameter('serializer.formats'),
       $container->get('logger.factory')->get('demo_restapi'),
       $container->get('current_user')
     );
   }

   /**
   * Responds to GET requests.
   *
   * Returns a list for blog entity.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
   public function get()
   {
     // Use current user after pass authentication to validate access.
    if (!$this->currentUser->hasPermission('access content'))
    {
      throw new AccessDeniedHttpException();
    }
    $entities = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'blog']);
    if(!empty($entities))
    {$result=array();
      foreach ($entities as $entity)
      {
        $result[] =  array('id' => $entity->id(), 'title' => $entity->title->value);
        $resultArray['response'] = $result;
       //$result[$entity->id()] = $entity->title->value;
      }

    }
    else {
      $resultArray = "There are no blog entries yet.";
    }

    $response = new ResourceResponse($resultArray);
    $response->addCacheableDependency($resultArray);
    return $response;
   }
 }
