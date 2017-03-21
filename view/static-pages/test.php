<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= GlobalConfig::getAppPath() ?>/about" data-save-btn="false">Open About</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= GlobalConfig::getAppPath() ?>/home" data-title="Home">Open Home</button>

<form class="form-inline">
    <div class="form-group">
        <label for="book">Book:</label><input id="book" class="form-control"></input>
        <label for="chapter">Chapter:</label><input id="chapter" class="form-control"></input>
        <label for="verse">Verses:</label><input id="verses" class="form-control"></input>
    </div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dynamic-modal" data-url="<?= GlobalConfig::getAppPath() ?>/scripture/view" data-title="Scripture" data-get-vars='["book","chapter","verses"]'>Load Verses</button>
</div>