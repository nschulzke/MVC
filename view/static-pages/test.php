<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= GlobalConfig::getAppPath() ?>/about" data-save-btn="false">Open About</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= GlobalConfig::getAppPath() ?>/home" data-title="Home">Open Home</button>

<?php include __DIR__ . '/../form/selectScripture.php' ?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= GlobalConfig::getAppPath() ?>/scripture/lookup" data-title="Scripture" data-params='["book","chapter","verses"]'>Load Verses</button>

<span class="verse-text">
    This is a <span class="footnote">test</span> paragraph <span class="footnote">with</span> a <span class="footnote">few</span> footnotes.
</span>

<script src="<?= GlobalConfig::getAppPath() ?>/rsc/js/highlight.js"></script>