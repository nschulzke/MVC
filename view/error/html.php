<?php
extract( $this->vars );
/**
 * variables needed here:
 * @var string $code
 * @var string $msg
 */
?>
<div class="error_message">
    <span class="error_code"><?= $code ?>: </span>
    <span class="error_message"><?= $msg ?></span>
</div>