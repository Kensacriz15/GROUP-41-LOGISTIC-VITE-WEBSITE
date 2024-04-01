@php
$containerFooter = (isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }}">
    <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
      <div>
        © <script>document.write(new Date().getFullYear())
      </script>,  GROUP-41-LOGISTIC ❤️
      </div>
      <div class="d-none d-lg-inline-block">
        <a href="/" class="footer-link me-4" >Home</a>
        <a href="/" class="footer-link me-4" >Help</a>
        <a href="https://github.com/Kensacriz15/GROUP-41-LOGISTIC-VITE-WEBSITE" class="footer-link me-4" >Github</a>
        <a href="/" class="footer-link me-4" >Support</a>
    </div>
  </div>
</footer>
<!--/ Footer-->
