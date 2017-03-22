<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= GlobalConfig::getAppPath() ?>/about" data-save-btn="false">Open About</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= GlobalConfig::getAppPath() ?>/home" data-title="Home">Open Home</button>

<?php include __DIR__ . '/../form/selectScripture.php' ?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= GlobalConfig::getAppPath() ?>/scripture/lookup" data-title="Scripture" data-params='["book","chapter","verses"]'>Load Verses</button>