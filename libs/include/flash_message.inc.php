<?php if($oFlashMessage->checkFlashMessage('success')): ?>
<div class="success"><?= $oFlashMessage->getFlashMessage('success') ?></div>
<?php endif; ?>
<?php if($oFlashMessage->checkFlashMessage('warning')): ?>
<div class="warning"><?= $oFlashMessage->getFlashMessage('warning') ?></div>
<?php endif; ?>
<?php if($oFlashMessage->checkFlashMessage('error')): ?>
<div class="error"><?= $oFlashMessage->getFlashMessage('error') ?></div>
<?php endif; ?>

