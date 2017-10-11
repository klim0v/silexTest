<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10.10.17
 * Time: 20:09
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FeedBackDeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', HiddenType::class)
            ->add('delete', SubmitType::class, [
                'label' => 'Delete',
            ]);
    }

    public function getName()
    {
        return 'del_feedback';
    }
}
