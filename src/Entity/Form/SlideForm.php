<?php

/**
 * @file
 * Contains \Drupal\slides_presentation\Entity\Form\SlideForm.
 */

namespace Drupal\slides_presentation\Entity\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\Language;

/**
 * Form controller for Slide edit forms.
 *
 * @ingroup slides_presentation
 */
class SlideForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\slides_presentation\Entity\Slide */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;
    
     $form['body'] = array(
      '#type' => 'text_format',
      '#default_value' => $entity->body->value,
      '#title' => $this->t('Description'),
      '#required' => FALSE,
    );

    $form['langcode'] = array(
      '#title' => $this->t('Language'),
      '#type' => 'language_select',
      '#default_value' => $entity->langcode->value,
      '#languages' => Language::STATE_ALL,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submit(array $form, FormStateInterface $form_state) {
    // Build the entity object from the submitted values.
    $entity = parent::submit($form, $form_state);

    return $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = $entity->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Slide.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Slide.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.slides_slide.edit_form', ['slides_slide' => $entity->id()]);
  }

}
