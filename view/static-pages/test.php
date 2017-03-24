<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= \config\Application::getAppPath() ?>/about" data-save-btn="false">
    Open About
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= \config\Application::getAppPath() ?>/home" data-title="Home">
    Open Home
</button>

<?php include __DIR__ . '/../_components/form/selectScripture.php' ?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= \config\Application::getAppPath() ?>/scripture/lookup" data-title="Scripture" data-params='["book","chapter","verses"]'>
    Load Verses
</button>
<p>
    Followed by a whole lot of text.
    Followed by a whole lot of text.
    Followed by a whole lot of text.
    Followed by a whole lot of text.
    Followed by a whole lot of text.
    Followed by a whole lot of text.
    <span class="verse-text">
        This is a <span class="footnote">test</span> paragraph <span class="footnote">with</span> a <span class="footnote">few</span> footnotes.
    </span>
    Followed by a whole lot of text.
    Followed by a whole lot of text.
    Followed by a whole lot of text.
    Followed by a whole lot of text.
    Followed by a whole lot of text.
    Followed by a whole lot of text.
    Followed by a whole lot of text.
</p>
<script src="<?= \config\Application::getAppPath() ?>/rsc/js/highlight.js"></script>