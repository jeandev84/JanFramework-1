<?php
namespace Jan\Component\Helpers;


/**
 * Class Serialiser
 * @package Jan\Component\Helpers
*/
class Serialiser
{

     /** @var array  */
     protected static $cache = [];


     /**
      * @param $name
      * @param $context
      * @return string
     */
     public static function serialise($name, $context)
     {
         self::$cache[$name] = serialize($context);
     }

     /**
      * @param $name
      * @return bool
     */
     public static function serialised($name)
     {
         return isset(self::$cache[$name]);
     }

     /**
      * @param $name
      * @return mixed
      * @throws \Exception
     */
     public static function deserialise($name)
     {
          if(! self::serialised($name))
          {
             self::abortIf(sprintf('This name %s is not serialized!', $name));
          }

          return unserialize(self::$cache[$name]);
     }

     /**
      * @param $message
      * @throws \Exception
     */
     protected static function abortIf($message)
     {
         throw new \Exception($message);
     }
}

/*
Example:

$user = new \App\Entity\User();
$user->setName('jean');
$user->setEmail('jeanyao@ymail.com');
$user->setPassword('secret');

Serializer::serialise('user.id', $user);

try {

    $context = Serializer::deserialise('user.id');
    dump($context);

} catch (\Exception $e) {

    dump($e->getMessage());

}
*/