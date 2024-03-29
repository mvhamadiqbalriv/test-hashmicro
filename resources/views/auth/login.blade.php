<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <link href="{{asset('/')}}assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{asset('/')}}assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{asset('/')}}assets/css/nucleo-svg.css" rel="stylesheet" />

    <link id="pagestyle" href="{{asset('/')}}assets/css/argon-dashboard.min.css?v=2.0.4" rel="stylesheet" />

    <!-- Scripts -->
    {{-- @vite(['resources/js/app.js']) --}}
</head>
<body>
    <div id="app">
        <main class="main-content  mt-0">
            <section>
              <div class="page-header min-vh-100">
                <div class="container">
                  <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                      <div class="card card-plain">
                        <div class="card-header pb-0 text-start">
                          <h4 class="font-weight-bolder">Sign In</h4>
                          <p class="mb-0">Enter your email and password to sign in</p>
                        </div>
                        <div class="card-body">
                          <form role="form" form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                              <input type="email" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror form-control-lg" placeholder="Email" aria-label="Email">
                              @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                              <input type="password" name="password" class="form-control @error('email') is-invalid @enderror form-control-lg" placeholder="Password" aria-label="Password">
                              @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="text-center">
                              <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                      <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
                  background-size: cover;">
                        <span class="mask bg-gradient-primary opacity-6"></span>
                        <h4 class="mt-5 text-white font-weight-bolder position-relative">"#HashMicro!"</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </main>
    </div>

    <script src="{{asset('/')}}assets/js/core/popper.min.js"></script>
    <script src="{{asset('/')}}assets/js/core/bootstrap.min.js"></script>
    <script src="{{asset('/')}}assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{asset('/')}}assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="{{asset('/')}}assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993" integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA==" data-cf-beacon='{"rayId":"7a44320fbe5e8992","version":"2023.2.0","r":1,"token":"1b7cbb72744b40c580f8633c6b62637e","si":100}' crossorigin="anonymous"></script>
</body>
</html>

