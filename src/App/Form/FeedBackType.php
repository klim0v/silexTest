<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10.10.17
 * Time: 20:09
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FeedBackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
    }

    public function getName()
    {
        return 'feedback';
    }
}
