@extends('layout')

@section('title', 'Eurovision 2020 - voter login')

@section('body')
<body>
  <div class="container">
      <div class="col-md-10 col-sm-12">
          <div class="card mb-4">
              <div class="card-header">
                  <h4 class="my-0 font-weight-normal">Eurovision 2020 official voting system</h4>
              </div>
              <div class="card-body">
                  <form>
                      <div class="form-group row">
                          <label for="inputPassword3" class="col-md-3 col-sm-4 col-form-label"><img src="assets/icons/keys-0.png" class="icon-16-4"> Secret access code</label>
                          <div class="col-sm-8 col-md-9">
                              <input type="text" class="form-95" id="inputPassword3">
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