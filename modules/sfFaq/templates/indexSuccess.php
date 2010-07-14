<?php include_partial('sfFaq/header') ?>

  <div id="tabs_sf_faq_categories">

    <?php foreach ($categoriesList as $key => $category): ?>
      <?php echo "BB".link_to(
                $category->getName(), 
                '@sf_faq?category_slug=' . $category->getSlug(),
                array(
                  'class' => ($selectedCategory && $selectedCategory->getId() == $category->getId()) ? 'tabs_sf_faq_category-on' : '',
                )
              ) ?> <?php echo sfConfig::get('app_sfFaqPlugin_separator', '|') ?>
    <?php endforeach ?>
  </div>

  <div class="question_separator"><?php echo sfConfig::get('app_sfFaqPlugin_question_separator', '<hr />') ?></div>
      
  <?php if ($selectedCategory): ?>
  
    <?php foreach ($selectedCategory->getsfFaqFaqs() as $key => $faq): ?>
      <?php if ($selectedFaq && $selectedFaq->getId() == $faq->getId()): ?>
        <div id="answer">
          <p class="question-on">
            <?php echo $faq->getQuestion() ?>
          </p>
          <p class="answer">
            <?php echo $faq->getAnswer() ?>
          </p>
        </div>
      <?php else: ?>
        <div class="question">
          > <?php 
        echo link_to(
          $faq->getQuestion(), 
          '@sf_faq?question_slug=' . stripText($faq->getQuestion())
          ) ?>
        </div>
      <?php endif ?>
      
      <div class="question_separator"><?php echo sfConfig::get('app_sfFaqPlugin_question_separator', '<hr />') ?></div>
          
    <?php endforeach ?>

  <?php endif ?>

<?php include_partial('sfFaq/footer') ?>
