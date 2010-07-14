<?php include_partial('sfFaq/header') ?>

<script type="text/javascript" charset="utf-8">
	function show_hide_element(element_id){
		if ($(element_id).visible()) {
			Effect.Highlight(element_id);
			Effect.Fade(element_id); 
		}
		else{
			Effect.Appear(element_id); 
			Effect.Highlight(element_id);
		}
	}
	
	function show_tab_category(element_id){
		<?php foreach ($categoriesList as $key => $category): ?>
			if (element_id == "div_category_<?php echo $category->getId() ?>"){
				Effect.Aappear', "div_category_" . $category->getId())
				Effect.Highlight', "div_category_" . $category->getId())
				$("a_category_<?php echo $category->getId() ?>").className = "tabs_sf_faq_category-on";
			}
			else{
				Effect.Fade', "div_category_" . $category->getId()) 
				$("a_category_<?php echo $category->getId() ?>").className = "tabs_sf_faq_category";
			}
		<?php endforeach ?>
	}
	
	function close_all_questions(seleted_element_id){
		<?php foreach ($categoriesList as $key => $category): ?>
			<?php foreach ($category->getsfFaqFaqs() as $key_faq => $faq): ?>
				<?php $element_id = 'div_answer_category_' . $category->getId() . '_' . $key_faq ?>
					if ('<?php echo $element_id ?>' == seleted_element_id){
						Effect.Aappear', $element_id)
						Effect.Highlight', $element_id)
					}
					else{
						Effect.Highlight', $element_id)
						Effect.Fade', $element_id) 
					}
			<?php endforeach ?>
		<?php endforeach ?>
	}
</script>

	<div id="tabs_sf_faq_categories">
		<?php foreach ($categoriesList as $key => $category): ?>
			<?php 
				$js_functions = "show_tab_category('div_category_" . $category->getId() . "');";
				if (sfConfig::get('app_sfFaqPlugin_close_all_question_with_category', false)) {
					$js_functions .= "close_all_questions(";
					if (sfConfig::get('app_sfFaqPlugin_first_question_by_default', false))
						$js_functions .= "'div_answer_category_" . $category->getId() . "_0'";
					$js_functions .= ");";
				}
				elseif (sfConfig::get('app_sfFaqPlugin_first_question_by_default', false)) 
					$js_functions .= "$('div_answer_category_" . $category->getId() . "_0').show();";
			?>
			<?php /*echo link_to_function(
											$category->getName(), 
											$js_functions,
											array(
												'id' => "a_category_" . $category->getId(), 
												'class' => ($selectedCategory && $selectedCategory->getId() == $category->getId()) ? 'tabs_sf_faq_category-on' : '', 
											)
									) */ ?> <?php echo sfConfig::get('app_sfFaqPlugin_separator', '|') ?>
		<?php endforeach ?>
	</div>

	<?php foreach ($categoriesList as $key => $category): ?>
		<div id="div_category_<?php echo $category->getId() ?>" <?php echo (!$selectedCategory || $selectedCategory->getId() != $category->getId()) ? 'style="display: none;"' : '' ?>>
		
			<div class="question_separator"><?php echo sfConfig::get('app_sfFaqPlugin_question_separator', '<hr />') ?></div>

			<?php foreach ($category->getsfFaqFaqs() as $key_faq => $faq): ?>
				<div class="question">
					> <?php //echo link_to_function($faq->getQuestion(), "show_hide_element('div_answer_category_" . $category->getId() . '_' . $key_faq . "')") ?>
				</div>

				<div id="div_answer_category_<?php echo $category->getId() . '_'  . $key_faq ?>" class="answer" <?php echo ((sfConfig::get('app_sfFaqPlugin_first_question_by_default', false) && $key_faq == 0) || ($selectedFaq && $selectedFaq->getId() == $faq->getId())) ? '' : 'style="display: none"' ?>>
					<?php echo $faq->getAnswer() ?>
				</div>
				<div class="question_separator"><?php echo sfConfig::get('app_sfFaqPlugin_question_separator', '<hr />') ?></div>
			<?php endforeach ?>

		</div>

	<?php endforeach ?>

<?php include_partial('sfFaq/footer') ?>
