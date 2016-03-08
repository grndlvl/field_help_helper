<?php

/**
 * @file
 * Contains \Drupal\devel\Form\ConfigEditor.
 */

namespace Drupal\field_help_helper\Form;

use Drupal\Core\Field\FieldFilteredMarkup;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field\FieldConfigInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityStorageInterface;

/**
 * Edit config variable form.
 */
class ConfigFieldHelp extends FormBase {

  /**
   * @var \Drupal\field\FieldConfigInterface
   */
  protected $fieldConfigStorage;

  /**
   * Constructs a new FieldConfigDeleteForm object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   */
  public function __construct(EntityStorageInterface $fieldConfigStorage) {
    $this->fieldConfigStorage = $fieldConfigStorage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')->getStorage('field_config')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'field_help_helper_config_field_help';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $field_id = '') {
    $form = array();

    $field_config = $this->fieldConfigStorage->load($field_id);
    if (empty($field_config)) {
      throw new NotFoundHttpException();
    }

    $form['#entity'] =  $field_config;

    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#default_value' => $field_config->getLabel() ?: $field_config->getName(),
      '#required' => TRUE,
    );

    $form['description'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Help text'),
      '#default_value' => $field_config->getDescription(),
      '#rows' => 5,
      '#description' => $this->t('Instructions to present to the user below this field on the editing form.<br />Allowed HTML tags: @tags', array('@tags' => FieldFilteredMarkup::displayAllowedTags())) . '<br />' . $this->t('This field supports tokens.'),
    );

    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    );
    $form['actions']['cancel'] = array(
      '#type' => 'link',
      '#title' => $this->t('Cancel'),
      '#url' => $this->getCancelLinkUrl(),
    );

    return $form;
  }

  /**
   * Builds the cancel link url for the form.
   *
   * @return Url
   *   Cancel url
   */
  private function getCancelLinkUrl() {
    $query = $this->getRequest()->query;

    if ($query->has('destination')) {
      $url = Url::fromUserInput($query->get('destination'));
    }
    else {
      $url = Url::fromRoute('<front>');
    }

    return $url;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $field_config = $form['#entity'];
    $field_config->setLabel($form_state->getValue('label'));
    $field_config->setDescription($form_state->getValue('description'));
    $field_config->save();
    $form_state->setRedirectUrl($this->getCancelLinkUrl());
  }

}
