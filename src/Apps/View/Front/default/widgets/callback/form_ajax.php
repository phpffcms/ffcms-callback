<?php

/** @var \Ffcms\Templex\Template\Template $this */
/** @var \Apps\Model\Front\Callback\FormAbstractCallback $model */
/** @var array $configs */

?>

<form id="callback-form">
    <div class="form-group">
        <input name="callback[name]" type="text" class="form-control" placeholder="<?= __('Name') ?>">
    </div>
    <div class="form-group">
        <input name="callback[phone]" type="text" class="form-control" placeholder="+7(___)-___-__-__">
    </div>
    <input name="callback[from]" type="hidden" value="<?= \App::$Request->getPathInfo() ?>" />
    <div class="row">
        <div class="col">
            <?php
            if ((bool)$configs['useCaptcha']) {
                if (\App::$Captcha->isFull()) {
                    echo \App::$Captcha->get();
                } else {
                    echo '<img src="' . \App::$Captcha->get() . '" alt="captcha"/>';
                    echo '<input name="callback[captcha]" type="text" class="form-control" placeholder="captcha" />';
                }
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button id="callback-submit" type="button" class="btn btn-primary"><?= __('Call me!') ?></button>
        </div>
    </div>
</form>

<script>
    $(function(){
        $('#callback-submit').on('click', function(){
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: script_url + '/api/callback/send?lang=' + script_lang,
                data: $('#callback-form').serialize(),
                success: function(res) {
                    alert(res.message);
                    $('form#callback-form').find('input[type=text]').val("");
                }
            });
        });
    });
</script>