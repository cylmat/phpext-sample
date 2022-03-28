<?php

namespace Phpext\Php\Closures;

use Phpext\AbstractCallable;

class Alpha { private $x = 1; }
class MyClass1 { public $obj1prop; }
class MyClass2 { public $obj2prop; }

class Closures extends AbstractCallable
{
   public function call(): array
   {
      return [
         $this->pre_7(),
         $this->post_7(),
         $this->test(),
      ];
   }

   function pre_7()
   {
      // Define a closure Pre PHP 7 code
      $getValue = function() {
         return $this->x;
      };

      // Bind a clousure
      $value = $getValue->bindTo(new Alpha, __NAMESPACE__.'\Alpha'); 
      print($value());
   }

   function post_7()
   {
      // PHP 7+ code, Define
      $value = function() {
         return $this->x;
      };

      print($value->call(new Alpha));
   }

   function test()
   {
      $obj1 = new MyClass1();
      $obj1->obj1prop = 'obj1';

      $obj2 = new MyClass2();
      $obj2->obj2prop = 'obj2';

      $serializedObj1 = serialize($obj1);
      $serializedObj2 = serialize($obj2);

      
      // default behaviour that accepts all classes
      // second argument can be ommited.
      // if allowed_classes is passed as false, unserialize converts all objects into __PHP_Incomplete_Class object
      $data = unserialize($serializedObj1 , ["allowed_classes" => true]);

      // converts all objects into __PHP_Incomplete_Class object except those of MyClass1 and MyClass2
      $data2 = unserialize($serializedObj2 , ["allowed_classes" => [
         __NAMESPACE__."\MyClass1",
         __NAMESPACE__."\MyClass2"
      ]]);

      print($data->obj1prop);
      print($data2->obj2prop);
   }
}
