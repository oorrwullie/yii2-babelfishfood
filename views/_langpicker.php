<?php

    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\web\View;

?>


    <div class="lang-form-contain">
	<form class="lang_form" id="language-form" action='<?= $url ?>' method="get">
	    <?= $title ?>
	    <select class="language-options" id="language-change" name="babelFishFood" onchange="this.form.submit()">
		<?php 
		    foreach ($languages as $language) {
			if ($language['name'] == $current_language) {
			    echo "<option value=".Html::encode($language['id'])." selected='selected'>".Html::encode($language['name'])."</option>";
			} else {
			    echo "<option value=".Html::encode($language['id']).">".Html::encode($language['name'])."</option>";
			}
		    }
		?>
	    </select>
	</form>
    </div>
