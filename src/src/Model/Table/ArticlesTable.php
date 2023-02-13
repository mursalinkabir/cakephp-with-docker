<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\Event\EventInterface;
use Cake\ORM\Table;
use Cake\Utility\Text;
// the Validator class
use Cake\Validation\Validator;

class ArticlesTable extends Table
{
    //initializes
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }
    //this funtion is called automaticall before every save and update operation
    public function beforeSave(EventInterface $event, $entity, $options)
    {
        //creating slug from title and assigning it
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);
            // trim slug to maximum length defined in schema
            $entity->slug = substr($sluggedTitle, 0, 191);
        }
    }
    //this method is called automatically for validation at form submit
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('title')
            ->minLength('title', 10)
            ->maxLength('title', 255)

            ->notEmptyString('body')
            ->minLength('body', 10);

        return $validator;
    }
}
