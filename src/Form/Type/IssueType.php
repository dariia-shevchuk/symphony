<?php

// src/Form/Type/TaskType.php
namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\IssueCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class IssueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Issue title'])
            ->add('description', TextareaType::class)
            ->add('category', EntityType::class, [
                'class' => IssueCategory::class,
                'choice_label' => 'name',
            ])
            ->add('contact_email', EmailType::class)
            ->add('contact_phone', TextType::class)
            ->add('is_contact_allowed', CheckboxType::class, [
                'label' => 'Zezwalam na kontakt zwrotny'
            ])
            ->add('save', SubmitType::class);
    }
}