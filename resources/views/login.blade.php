@extends('layout')

@section('title', 'Eurovision 2020')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
<div class="container">
    <div class="col-sm-6">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Eurovision 2020 official voting system</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-6 col-form-label"><img src="assets/icons/keys-0.png" class="icon-16-4"> Secret access code</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-95" id="inputPassword3">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection