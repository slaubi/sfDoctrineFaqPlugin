<?php

/**
 * Faq module
 *
 * The front can be full JS nothing reload OR one click reload the page with a good URL for the referencement
 * cf : README
 *
 * @package sfDoctrineFaqPlugin
 * @author Jonathan Démoutiez <jonathan@demoutiez.net>
 * @author Susan Lau <susan.lau@gmx.de> 
 */
class BasesfFaqActions extends sfActions
{
  public function preExecute()
  {
    if (sfConfig::get('app_sfDoctrineFaqPlugin_js', false) && $this->getActionName() != 'indexJs') 
    {
      $this->forward('sfFaq', 'indexJs');
    }
    if (!sfConfig::get('app_sfDoctrineFaqPlugin_js', false) && $this->getActionName() != 'index') 
    {
      $this->forward('sfFaq', 'index');
    }

    $this->initList();
  }

  public function executeIndex() 
  {
    if ($this->hasRequestParameter('faq_id')) 
    {
      $this->setVar('selectedFaq', Doctrine::getTable('sfFaqFaq')->find($this->getRequestParameter('faq_id')));
    }

    if (!isset($this->selectedFaq) && !$this->selectedFaq) 
    {
      if ($this->hasRequestParameter('category_id'))
      {
	$this->setVar('selectedCategory', Doctrine::getTable('sfFaqCategory')->find($this->getRequestParameter('category_id')));
	$this->defaultQuestionSelection();
      }
      else
      {
	$this->defaultSelection();
      }
    }
    else 
    {
      $this->setVar('selectedCategory', $this->selectedFaq->getsfFaqCategory());
    }
  }

  public function executeIndexJs() 
  {
    $this->defaultSelection();
  }
	
  /**
   * Private methods
   *
   * @author Jonathan Démoutiez
   */
  private function initList()
  {
    $this->setVar('categoriesList', Doctrine::getTable('sfFaqCategory')->retrieveAll());
  }
	
  private function defaultSelection()
  {
    $this->defaultCategorySelection();
    $this->defaultQuestionSelection();
  }
	
  private function defaultCategorySelection()
  {
    if (sfConfig::get('app_sfDoctrineFaqPlugin_first_category_by_default', false) && !isset($this->selectedCategory) && !$this->selectedCategory) 
    {
      $this->setVar('selectedCategory', Doctrine::getTable('sfFaqCategory')->retrieveFirst());
      $this->defaultQuestionSelection();
    }
    else
    {
      $this->setVar('selectedCategory', NULL);
      $this->setVar('selectedFaq', NULL);
    }
  }
	
  private function defaultQuestionSelection()
  {
    if (sfConfig::get('app_sfDoctrineFaqPlugin_first_question_by_default', false) && $this->selectedCategory)
    {
      $selectedFaqs = $this->selectedCategory->getsfFaqFaqs();
      if (is_array($selectedFaqs)) 
      {
	$this->setVar('selectedFaq', array_shift($selectedFaqs));
      }
    }
    else 
    {
      $this->setVar('selectedFaq', NULL);
    }
  }
}
