<?php

/**
 * @file
 * Contains Drupal\demo_restapi\Plugin\rest\resource\CreateBlogResource.
 */

namespace Drupal\demo_restapi\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Psr\Log\LoggerInterface;
use Drupal\node\Entity\Node;
use \Drupal\file\Entity\File;
//use Drupal\demo_restapi\Base64Image;
/**
 * Creates a new node in Blog entity.
 *
 * @RestResource(
 *   id = "create_blog",
 *   label = @Translation("Create blog rest api resource"),
 *   uri_paths = {
 *     "create" = "/api/create_blog"
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
     * Create a node using rest api.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function post($data)
    {
      \Drupal::logger('demo_restapi')->debug('<pre>' . print_r($data, TRUE) . '</pre>');

      if(!$this->currentUser->hasPermission('access content'))
      {
       throw new AccessDeniedHttpException();
      }

      $path = 'public://';
      if (!empty($data['image']))
      {
        $base_64_str = $data['image'];
        // Clean base64 string.
        $pos = strpos($base_64_str, ',');
        if ($pos !== FALSE)
        {
          $base_64_str = substr($base_64_str, ++$pos);
        }
        // Decode base64 data.
        $base64 = base64_decode($base_64_str);
      }
      $filename = $path . $data['image_filename'];
        // Save the file.
      $file = file_save_data($base64, $filename, FILE_EXISTS_REPLACE);


      $fid1 = $file->id();

      //$node = \Drupal::entityTypeManager()->getStorage('node')->create([
      $node = Node::create([
        'type' => 'blog',
        'title' => $data['title'],
        'body' => $data['body'],
        'field_blog_category' =>  $data['category'],
        'field_blog_image' => [
          'target_id' => $fid1,
          'alt' => $data['image_filename'],
        ],
      ]);

      $node->enforceIsNew(TRUE);
      $node->save();

      $result[$node->id()] = $node->title->value;

      $response = new ResourceResponse($result);
      $response->addCacheableDependency($result);

      return $response;

    }

 }
