<!doctype html>

<html
  lang="es"
  class="layout-wide customizer-hide"
  dir="ltr"
  data-skin="default"
  data-assets-path="/vuexy/assets/"
  data-template="vertical-menu-template"
  data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $textos['titulo']}}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/vuexy/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="/vuexy/assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="/vuexy/assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="/vuexy/assets/vendor/libs/pickr/pickr-themes.css" />

    <link rel="stylesheet" href="/vuexy/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="/vuexy/assets/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="/vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <!-- Vendor -->
    <link rel="stylesheet" href="/vuexy/assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="/vuexy/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="/vuexy/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="/vuexy/assets/vendor/js/template-customizer.js"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="/vuexy/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover">
      @include('backoffice._partials.header')
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-xl-flex col-xl-8 p-0">
          <div class="auth-cover-bg d-flex justify-content-center align-items-center">
            <img
              src="{{ asset('/vuexy/assets/img/illustrations/auth-login-illustration-light.png') }}"
              alt="auth-login-cover"
              class="my-5 auth-illustration"
              data-app-light-img="illustrations/auth-login-illustration-light.png"
              data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
            <img
              src="{{ asset('/vuexy/assets/img/illustrations/bg-shape-image-light.png') }}"
              alt="auth-login-cover"
              class="platform-bg"
              data-app-light-img="illustrations/bg-shape-image-light.png"
              data-app-dark-img="illustrations/bg-shape-image-dark.png" />
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
          <div class="w-px-400 mx-auto mt-12 pt-5">
            <div class="text-center mb-4">
                <img src="{{$textos['logo']}}" alt="logo" width="150px">
            </div>
            <h4 class="mb-1">{{ $textos['formulario']['titulo'] }}</h4>
            <p class="mb-6">{{ $textos['formulario']['instruccion'] }}</p>
            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endif

            <form id="formAuthentication" class="mb-6" action="{{ route('user.form.login') }}" method="POST">    
                @csrf
              <div class="mb-6 form-control-validation">
                <label for="email" class="form-label">Usuario</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="username"
                  placeholder="Ingrese su usuario"
                  autofocus />
              </div>
              <div class="mb-6 form-password-toggle form-control-validation">
                <label class="form-label" for="password">Contraseña</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" 
                    />
                  <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
                </div>
              </div>
              <div class="my-8">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0 ms-2">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Recordar </label>
                  </div>
                  <a href="auth-forgot-password-cover.html">
                    <p class="mb-0">¿Olvidó su contraseña?</p>
                  </a>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100" type="submit">Iniciar Sesión</button>
            </form>

            <p class="text-center">
              <span>¿Eres un usuario nuevo?</span>
              <a href="{{ route('user.form.show.registro') }}">
                <span>Crea una cuenta</span>
              </a>
            </p>

            @include('backoffice._partials.footer')

          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js -->

    <script src="/vuexy/assets/vendor/libs/jquery/jquery.js"></script>

    <script src="/vuexy/assets/vendor/libs/popper/popper.js"></script>
    <script src="/vuexy/assets/vendor/js/bootstrap.js"></script>
    <script src="/vuexy/assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="/vuexy/assets/vendor/libs/@algolia/autocomplete-js.js"></script>

    <script src="/vuexy/assets/vendor/libs/pickr/pickr.js"></script>

    <script src="/vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/vuexy/assets/vendor/libs/hammer/hammer.js"></script>

    <script src="/vuexy/assets/vendor/libs/i18n/i18n.js"></script>

    <script src="/vuexy/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/vuexy/assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="/vuexy/assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="/vuexy/assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Main JS -->

    <script src="/vuexy/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/vuexy/assets/js/pages-auth.js"></script>
  </body>
</html>