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
        This is a <a class="footnote" href="#" data-book="john" data-chapter="3" data-verse="16">test</a> paragraph <a class="footnote" href="#" data-book="mosiah" data-chapter="3" data-verse="19">with</a> a <a class="footnote" href="#" data-book="moses" data-chapter="1" data-verse="39">few</a> footnotes.
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