<?php

/** @var \Ffcms\Templex\Template\Template $this */
/** @var \Apps\Model\Front\Callback\FormAbstractCallback $model */

?>

<form id="callback-form">
    <div class="form-group">
        <input name="callback[name]" type="text" class="form-control" placeholder="<?= __('Name') ?>">
    </div>
    <div class="form-group">
        <input name="callback[phone]" type="text" class="form-control" placeholder="+7(___)-___-__-__">
    </div>
    <button id="callback-submit" type="button" class="btn btn-primary"><?= __('Call me!') ?></button>
</form>

<script>
    $(function(){
        $('#callback-submit').on('click', function(){

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: script_url + '/api/callback/send?lang=en',
                data: $('#callback-form').serialize(),
                success: function(res) {
                    console.log(res.message);
                }
            });
        });
    });
</script>