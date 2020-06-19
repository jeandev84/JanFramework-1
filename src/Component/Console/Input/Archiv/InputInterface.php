<?php
namespace Jan\Component\Console\Input;


/**
 * Interface InputInterface
 * @package Jan\Component\Console\Input
*/
interface InputInterface
{

     /**
      * Get first argument of input
      * @return mixed
     */
     public function getFirstArgument();


     /**
      * Validation definitions
      *
      * @return mixed
     */
     public function validate();


     /**
      * @param string $name
      * @return bool
     */
     public function hasParameterOption(string $name);


     /**
      * @param string $name
      * @return mixed
     */
     public function getParameterOption(string $name);


     /**
      * @return mixed
     */
     public function getArguments();


     /**
      * @param string $name
      * @return mixed
     */
     public function getArgument(string $name);


     /**
      * @return bool
     */
     public function isInteractive();
}