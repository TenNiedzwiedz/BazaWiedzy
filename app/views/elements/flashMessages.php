<?php
  use app\core\Application;
?>

<div id="flashMessages">
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <?php if($flashMessage = Application::$app->session->checkFlash()): ?>
      <div id="FlashMessage" class="toast text-white bg-<?= $flashMessage['type'] ?> bg-opacity-50 border-0" data-bs-delay="7500" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header text-white bg-<?= $flashMessage['type'] ?> bg-opacity-50">
          <i class="bi bi-bell-fill"></i>
          <strong class="me-auto">&nbsp;<?= $flashMessage['label'] ?></strong>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          <?= $flashMessage['message'] ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
  function showFlashMessage()
  {
    const flashMessageToast = document.getElementById('FlashMessage')
    if (flashMessageToast) {
      const toast = new bootstrap.Toast(flashMessageToast);

      toast.show()
    }
  }
  </script>
