<h2><?php echo h($error['message']); ?></h2>
<p class="error">
    <strong>Api Error</strong>
    <strong><?php echo h($meta['url']); ?></strong>
</p>
<?php
if (Configure::read('debug') > 0):
    echo $this->element('exception_stack_trace', array('error' => $error_exception));
endif;