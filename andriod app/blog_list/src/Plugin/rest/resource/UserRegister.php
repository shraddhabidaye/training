<?php

/**
 * @file
 * Contains Drupal\blog_list\Plugin\rest\resource\UserRegister.
 */

namespace Drupal\blog_list\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\user\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Exception;
//use Drupal\demo_restapi\Base64Image;
/**
 * Creates a new node in Blog entity.
 *
 * @RestResource(
 *   id = "user_regiser",
 *   label = @Translation("User Register"),
 *   uri_paths = {
 *     "create" = "/api/register"
 *   }
 * )
 */
class UserRegister extends ResourceBase
 {
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
    */
   public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger)
    {
      parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);

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
        $container->get('logger.factory')->get($plugin_id)
      );
    }

    /**
     * Responds to POST requests.
     *
     * Create a new user.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function post($data)
    {

      $result = [];
      $message = '';
      $error = FALSE;
      foreach ($data as $field => $value)
      {
        if (empty($value))
        {
          $message = ' Entity: ' . $field . ' field should not be empty.';
          $status_code = 422;
          $error = TRUE;
          break;
        }

        if($field == 'mail')
        {
          $email = $data['mail'];
          if (!filter_var($email, FILTER_VALIDATE_EMAIL))
          {
            $message = 'Invalid input ' . $field . ' field .It should be in format: Username@domainname.com.';
            $status_code = 422;
            $error = TRUE;
          }
          else
          {
            $emails = \Drupal::entityQuery('user')
              ->condition('mail', $value)
              ->execute();
            if (!empty($emails))
            {
              $message = 'Not Acceptable: Email already exists.';
              $status_code = 406;
              $error = TRUE;
            }
          }
        }

        if($field =='name'){
          $user = user_load_by_name($value);
          if (!empty($user)) {
            $message = 'Not Acceptable: Username already exists.';
            $status_code = 406;
            $error = TRUE;
          }
        }
      }

      if ($error == TRUE && !empty($message))
      {
        $result = [
          'status' => FALSE,
          'error' => [
            'message' => $message,
            'statusCode' => $status_code,
          ],
        ];
      }
      else
      {
        try
        {
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

          $account = User::create([
            'name' => $data['name'],
            'mail' => $data['mail'],
            'user_picture' => [
              'target_id' => $fid1,
              'alt' => $data['image_filename'],
            ]
          ]);

          $account->enforceIsNew();
          $account->save();

          $result = [
            'status' => TRUE,
            'uid' => $account->id(),
          ];

        }
        catch(Exception $e)
        {
          Drupal::logger('blog_list')->error($e->getMessage());
          throw new Exception($e->getMessage());
        }
      }

      $response = new ResourceResponse($result);
      $response->addCacheableDependency($result);

      return $response;

    }

 }
