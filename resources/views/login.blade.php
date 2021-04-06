@extends('layout')

@section('title', 'Eurovision 2020 - voter login')

@section('body')
<body>
  <div class="container">
      <div class="col-md-10 col-sm-12">
          <div class="card mb-4">
              <div class="card-header">
                  <h4 class="my-0 font-weight-normal">Eurovision 2021 - the pandemic continues</h4>
              </div>
              <div class="card-body">
                  <form action="{{ url('voting') }}" method="post">
                      <div class="form-group row">
                          <label for="inputPassword3" class="col-md-3 col-sm-4 col-form-label">
                              <img src="{{ asset('assets/icons/keys-0.png') }}" class="icon-16-4"> Secret access code
                          </label>
                          <div class="col-sm-8 col-md-9">
                              <input name="secret_code" type="text" class="form-95 is-invalid" id="inputPassword3">
                              <div class="invalid-feedback">
                                  @if(session('error'))
                                      <img src="{{ asset('assets/icons/msg_warning-2.png') }}" class="icon-16-4">
                                      {{ session('error') }}
                                  @endif
                              </div>                      
                          </div>                          
                      </div>
                      <div class="form-group row">
                          <div class="col-sm-3">
                              <button type="submit" class="btn btn-primary">Login</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</body>
@endsection
