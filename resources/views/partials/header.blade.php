<body>
<div id="alt-menu" style="display: none;">
  <button id="close_cross">
    <img id="close_cross_img" src="/mvc_part/css/Assets/close-cross.png" alt="Close menu">
  </button>
  <nav class="container flex">
    <a href="{{ route('store') }}" class="decor">Каталог</a>
    <br>
    <a href="{{ route('home') }}" class="decor">О нас</a>
    <br>
    <a href="{{ route('faq') }}" class="decor">Как заказать</a>
    <div class="cartholder">
      <span id="cart_counter_phone">
        <?= $cartItems['total'] ?? 0 ?> товаров<br>
        <span id="price_counter_phone"><?= $cartItems['price'] ?? 0 ?> рублей</span>
      </span>
      <button id="cart_phone">
        <a href="{{ route('cart') }}">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAC60lEQVR4nO3cvY9MURjH8YPYDQkR2UaoDYXWS7WFxF/ARC1EM6NZkWgk2H4JErIFWhGSaVToLBuMGt1IvMSulxkSYX3lZk4xzZnd2bj3Oec5z6faYpPnOb/cufeceSbXOWOMMcaYygEbgWvAV8IWgIfASWBD9V0qAFxnNG+BvdJ9JwVYC/xkdD+AA9L95xB04R2wSXoNmm8dg85K95+M4uEGXAG+rCLo19L9qwGsA44OCXu3dI+qAM8DQZ+W7k0V4Hwg6MfSvalS7J0DQf8Gtkj3p20r+CEQdl26P1WAm4Ggb0v3pgpwOBD0p+KKl+5PDWAz8CsQ9n7p/lQBHgWCvijdmyrAVCDol9K9qQLUAkH/BXZI96cK8CYQ9gnp3lQBLgWCzskCMAOMlRn0IelVRmSmzKDHga70CiPxubSgfdj3pFcYicWygz4uvcJItMoOepvf0uWuWWrQPuwX0quMQK2KoC+Qt07pIfug95G32RiGATmobuAB3CJPS8BElUEfIU/zlYW8gmGAZtOVBr3MMECzyZiGAVr1iu97JILeRV5alYe8gmGARk3JoC+Tj5pk0LkMAzpiIQ8MA76j36xo0D7s++hXl845h2HAUqXH7oyHAfMuFsqHAdMuFsqHAZMuFoqHAT2RY3eGw4CWi43SYUDTxUbpMKDmYqNwGNBxsULXMED+2J3JMKDuYgXsRIfiFrjVxQx4QvruutgBB0nbH2CPSwFwg3Sdc6kA1gN3SM9VYI1LCf1j+ZR/6VXsFoFjLmXABHDG77E/+i/SY7gPvwceAA17IZcxxhhjzGp/1XQKeOpncT3/d7PMuZxUXRHAduDVkH1tu/gfLXVF0L+ihi12cNHjqdcVQ/9ju1KN1OuKAZ6NsOC51OuKYbR3fHRTryuG0Rb8LfW6YrBbR2VBN4UehiJ1xdDfZhVbqOW0/+fbt6TqiqJ/cGgLHVgqrysKGPPTjDn/oOr6nyY0yryipOoaY4wxxhhjjIvNP1oG66QRTSVLAAAAAElFTkSuQmCC" alt="Cart" id="cart_img_phone">
        </a>
      </button>
    </div>
  </nav>
</div>

<header class="container flex">
  <div class="logosection">
    <a href="{{ route('home') }}">
      <img src="{{ asset('assets/goldgrif.png') }}" alt="Logo" class="logo">
    </a>
    <a href="{{ route('home') }}">
      <h2 id="logo-name">Золотой<br>грифон</h2>
    </a>
  </div>

  <nav>
    <ul>
      <li><a href="{{ route('store') }}" class="decor">Каталог</a></li>
      <li><a href="{{ route('home') }}" class="decor">О нас</a></li>
      <li><a href="{{ route('faq') }}" class="decor">Как заказать</a></li>
    </ul>
  </nav>

  <div id="cart_and_prof">
    <div class="cartholder">
      <span id="cart_counter">
        <?= $cartItems['total'] ?? 0 ?> товаров<br>
        <span id="price_counter"><?= $cartItems['price'] ?? 0 ?> рублей</span>
      </span>
      <button id="cart">
        <a href="{{ route('cart') }}">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAC60lEQVR4nO3cvY9MURjH8YPYDQkR2UaoDYXWS7WFxF/ARC1EM6NZkWgk2H4JErIFWhGSaVToLBuMGt1IvMSulxkSYX3lZk4xzZnd2bj3Oec5z6faYpPnOb/cufeceSbXOWOMMcaYygEbgWvAV8IWgIfASWBD9V0qAFxnNG+BvdJ9JwVYC/xkdD+AA9L95xB04R2wSXoNmm8dg85K95+M4uEGXAG+rCLo19L9qwGsA44OCXu3dI+qAM8DQZ+W7k0V4Hwg6MfSvalS7J0DQf8Gtkj3p20r+CEQdl26P1WAm4Ggb0v3pgpwOBD0p+KKl+5PDWAz8CsQ9n7p/lQBHgWCvijdmyrAVCDol9K9qQLUAkH/BXZI96cK8CYQ9gnp3lQBLgWCzskCMAOMlRn0IelVRmSmzKDHga70CiPxubSgfdj3pFcYicWygz4uvcJItMoOepvf0uWuWWrQPuwX0quMQK2KoC+Qt07pIfug95G32RiGATmobuAB3CJPS8BElUEfIU/zlYW8gmGAZtOVBr3MMECzyZiGAVr1iu97JILeRV5alYe8gmGARk3JoC+Tj5pk0LkMAzpiIQ8MA76j36xo0D7s++hXl845h2HAUqXH7oyHAfMuFsqHAdMuFsqHAZMuFoqHAT2RY3eGw4CWi43SYUDTxUbpMKDmYqNwGNBxsULXMED+2J3JMKDuYgXsRIfiFrjVxQx4QvruutgBB0nbH2CPSwFwg3Sdc6kA1gN3SM9VYI1LCf1j+ZR/6VXsFoFjLmXABHDG77E/+i/SY7gPvwceAA17IZcxxhhjzGp/1XQKeOpncT3/d7PMuZxUXRHAduDVkH1tu/gfLXVF0L+ihi12cNHjqdcVQ/9ju1KN1OuKAZ6NsOC51OuKYbR3fHRTryuG0Rb8LfW6YrBbR2VBN4UehiJ1xdDfZhVbqOW0/+fbt6TqiqJ/cGgLHVgqrysKGPPTjDn/oOr6nyY0yryipOoaY4wxxhhjjIvNP1oG66QRTSVLAAAAAElFTkSuQmCC" alt="Cart" id="cart_img">
        </a>
      </button>
    </div>

    <div class="profile" id="profileToggle">
      <img src="data:image/svg+xml,%3c?xml%20version=%271.0%27%20encoding=%27utf-8%27?%3e%3c!--%20Uploaded%20to:%20SVG%20Repo,%20www.svgrepo.com,%20Generator:%20SVG%20Repo%20Mixer%20Tools%20--%3e%3csvg%20width=%27800px%27%20height=%27800px%27%20viewBox=%270%200%2024%2024%27%20fill=%27none%27%20xmlns=%27http://www.w3.org/2000/svg%27%3e%3cg%20clip-path=%27url(%23clip0_15_82)%27%3e%3crect%20width=%2724%27%20height=%2724%27%20fill=%27white%27/%3e%3cg%20filter=%27url(%23filter0_d_15_82)%27%3e%3cpath%20d=%27M14.3365%2012.3466L14.0765%2011.9195C13.9082%2012.022%2013.8158%2012.2137%2013.8405%2012.4092C13.8651%2012.6046%2014.0022%2012.7674%2014.1907%2012.8249L14.3365%2012.3466ZM9.6634%2012.3466L9.80923%2012.8249C9.99769%2012.7674%2010.1348%2012.6046%2010.1595%2012.4092C10.1841%2012.2137%2010.0917%2012.022%209.92339%2011.9195L9.6634%2012.3466ZM4.06161%2019.002L3.56544%2018.9402L4.06161%2019.002ZM19.9383%2019.002L20.4345%2018.9402L19.9383%2019.002ZM16%208.5C16%209.94799%2015.2309%2011.2168%2014.0765%2011.9195L14.5965%2012.7737C16.0365%2011.8971%2017%2010.3113%2017%208.5H16ZM12%204.5C14.2091%204.5%2016%206.29086%2016%208.5H17C17%205.73858%2014.7614%203.5%2012%203.5V4.5ZM7.99996%208.5C7.99996%206.29086%209.79082%204.5%2012%204.5V3.5C9.23854%203.5%206.99996%205.73858%206.99996%208.5H7.99996ZM9.92339%2011.9195C8.76904%2011.2168%207.99996%209.948%207.99996%208.5H6.99996C6.99996%2010.3113%207.96342%2011.8971%209.40342%2012.7737L9.92339%2011.9195ZM9.51758%2011.8683C6.36083%2012.8309%203.98356%2015.5804%203.56544%2018.9402L4.55778%2019.0637C4.92638%2016.1018%207.02381%2013.6742%209.80923%2012.8249L9.51758%2011.8683ZM3.56544%2018.9402C3.45493%2019.8282%204.19055%2020.5%204.99996%2020.5V19.5C4.70481%2019.5%204.53188%2019.2719%204.55778%2019.0637L3.56544%2018.9402ZM4.99996%2020.5H19V19.5H4.99996V20.5ZM19%2020.5C19.8094%2020.5%2020.545%2019.8282%2020.4345%2018.9402L19.4421%2019.0637C19.468%2019.2719%2019.2951%2019.5%2019%2019.5V20.5ZM20.4345%2018.9402C20.0164%2015.5804%2017.6391%2012.8309%2014.4823%2011.8683L14.1907%2012.8249C16.9761%2013.6742%2019.0735%2016.1018%2019.4421%2019.0637L20.4345%2018.9402Z%27%20fill=%27%23000000%27/%3e%3c/g%3e%3c/g%3e%3cdefs%3e%3cfilter%20id=%27filter0_d_15_82%27%20x=%272.55444%27%20y=%273.5%27%20width=%2718.8911%27%20height=%2719%27%20filterUnits=%27userSpaceOnUse%27%20color-interpolation-filters=%27sRGB%27%3e%3cfeFlood%20flood-opacity=%270%27%20result=%27BackgroundImageFix%27/%3e%3cfeColorMatrix%20in=%27SourceAlpha%27%20type=%27matrix%27%20values=%270%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200%20127%200%27%20result=%27hardAlpha%27/%3e%3cfeOffset%20dy=%271%27/%3e%3cfeGaussianBlur%20stdDeviation=%270.5%27/%3e%3cfeColorMatrix%20type=%27matrix%27%20values=%270%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200%200.1%200%27/%3e%3cfeBlend%20mode=%27normal%27%20in2=%27BackgroundImageFix%27%20result=%27effect1_dropShadow_15_82%27/%3e%3cfeBlend%20mode=%27normal%27%20in=%27SourceGraphic%27%20in2=%27effect1_dropShadow_15_82%27%20result=%27shape%27/%3e%3c/filter%3e%3cclipPath%20id=%27clip0_15_82%27%3e%3crect%20width=%2724%27%20height=%2724%27%20fill=%27white%27/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e" alt="Profile" id="prof_pic">
      <div id="profileDropdown" class="profile-dropdown" style="display: none;">
        <a href="{{ route('login') }}" class="dropdown-item">Войти</a>
        <a href="{{ route('registration') }}" class="dropdown-item">Зарегистрироваться</a>
      </div>
    </div>
  </div>

  <img src="/mvc_part/css/Assets/burger-menu.png" alt="Menu" id="bur-menu">
</header>
<script>
document.getElementById('bur-menu').addEventListener('click', function() {
  document.getElementById('alt-menu').style.display = 'block';
  document.querySelector('header').style.display = 'none';
});

document.getElementById('close_cross').addEventListener('click', function() {
  document.getElementById('alt-menu').style.display = 'none';
  document.querySelector('header').style.display = 'flex';
});

document.getElementById('profileToggle').addEventListener('click', function(e) {
  e.stopPropagation();
  const dropdown = document.getElementById('profileDropdown');
  if (dropdown) {
    dropdown.style.display = dropdown.style.display === 'none' ? 'flex' : 'none';
  }
});

document.addEventListener('click', function(e) {
  const dropdown = document.getElementById('profileDropdown');
  if (dropdown && !e.target.closest('#profileToggle')) {
    dropdown.style.display = 'none';
  }
});
</script>