<?php

/** @var int $id */
/** @var string $phone */
/** @var string $date */

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <style type="text/css">blockquote {
            border-left: 4px solid #CCC;
            margin-left: 0;
            padding-left: 1em;
        }</style>
</head>
<body>
<table align="center" cellspacing="0" border="0" cellpadding="0" width="580" bgcolor="#FFFFFF"
       style="width:580px;background-color:#FFF;border-top:1px solid #DDD;border-bottom:1px solid #DDD;">
    <tbody>
    <tr>
        <td style="padding-top:34px;padding-left:39px;padding-right:39px;text-align:left;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;">
            <h2 style="font-family:Helvetica Neue,Arial,Helvetica,sans-serif;font-size:30px;color:#262626;font-weight:normal;margin-top:0;margin-bottom:13px;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                <?= __('New callback request %id%', ['id' => $id]) ?>
            </h2>

            <h3 style="font-family:Helvetica Neue,Arial,Helvetica,sans-serif;font-size:16px;color:#3e434a;font-weight:normal;margin-top:0;margin-bottom:19px;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;line-height:25px;">
                <?= __('New callback request from client: %phone% at %date%', ['phone' => $phone, 'date' => $date]) ?>
            </h3>
        </td>
    </tr>
    <tr>
        <td align="left"
            style="background-color:#F1FAFE;font-size:14px;color:#1f1f1f;border-top-width:1px;border-top-style:solid;border-top-color:#DAE3EA;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#DAE3EA;border-left-width:1px;border-left-style:solid;border-left-color:#DDD;border-right-width:1px;border-right-style:solid;border-right-color:#DDD;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:20px;padding-bottom:20px;padding-right:39px;padding-left:39px;text-align:left;">
            <table cellspacing="0" border="0" cellpadding="0" width="500" align="left">
                <tbody>
                <tr>
                    <td align="left" style="font-family:Helvetica Neue,Arial,Helvetica,sans-serif;padding-left:9px;font-size:14px;">
                        <a href="<?= \App::$Alias->scriptUrl ?>/admin/callback/read/<?= $id ?>"><?= __('View request') ?></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
    </tr>
    </tbody>
</table>
</body>
</html>