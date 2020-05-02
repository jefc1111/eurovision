@extends('layout')

@section('title', 'Eurovision 2020 - voting')

@section('body')
<body class="bg-cloud">
  <div class="container">
    <table class="table table-bordered">
      <thead>
        <th>Name</th>
        <th>Flag</th>
      </thead>
      <tbody>
        @foreach($countries->sortBy('name') as $country)
        <tr>
          <td>
            {{ $country->name }}
          </td>
          <td>
            <img src="{{ $country->getFlagUrl() }}">
          </td>
        </tr>
        @endforeach
        </tbody>
      </table>
  </div>
</body>

<style>
table {
  background: #323232;  
}

table th, table td {
  color: #efefef;
} 
</style>

@endsection
