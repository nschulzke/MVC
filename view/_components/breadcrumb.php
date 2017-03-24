<?php
?>
<ol class="breadcrumb sticky-top">
<?php foreach ($this->vars['breadcrumb'] as $name => $path):
    $active = $this->vars['activeCrumb'] == $name;
?>
    <li class="breadcrumb-item<?= $active ? ' active' : '' ?>">
        <?= $active ? '' : '<a href="' . $path . '">' ?><?= $name ?><?= $active ? '' : '</a>' ?>
    </li>
<?php endforeach ?>
</ol>