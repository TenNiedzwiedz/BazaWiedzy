<?php
  use app\core\Application;
?>

<div id="flashMessages">
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="flashMessage" class="toast text-white bg-opacity-50 border-0" data-bs-delay="7500" role="alert">
        <div id ="flashHeader" class="toast-header text-white bg-opacity-50">
          <i class="bi bi-bell-fill"></i>
          <strong id="flashTitle" class="me-auto">&nbsp;</strong>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div id="flashBody" class="toast-body">
        </div>
      </div>
  </div>
</div>

<script>
  var flashMessage = <?= json_encode(Application::$app->session->checkFlash()) ?>;

  function showFlashMessage(message = false)
  {
    if(message) {
      flashMessage = JSON.parse(message);
      console.log(flashMessage);
    }
    const flashMessageToast = document.getElementById('flashMessage');
    const flashHeader = document.getElementById('flashHeader');
    const flashTitle = document.getElementById('flashTitle');
    const flashBody = document.getElementById('flashBody');

    if (flashMessage) {
      const toast = new bootstrap.Toast(flashMessageToast);

      const types = ['success', 'warning', 'danger'];
      types.forEach(function (type) {
        flashMessageToast.classList.remove('bg-'+type);
        flashHeader.classList.remove('bg-'+type);
      });
      flashMessageToast.classList.add('bg-'+flashMessage.type);
      flashHeader.classList.add('bg-'+flashMessage.type);
      flashTitle.innerHTML = '&nbsp;'+flashMessage.label;
      flashBody.innerText = flashMessage.message;

      toast.show();
    }
  }
  </script>
