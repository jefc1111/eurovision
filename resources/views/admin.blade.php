@extends('layout')

@section('title', 'Eurovision 2020')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
<div class="container">
<table class="table table-bordered">
  <thead>
    <th>Name</th>
    <th>Secret code</th>
    <th>Flag</th>
    <th>Voter name</th>
    <th>Vote data</th>
    <th>Voting complete</th>
  </thead>
  <tbody>
    @foreach($countries->sortBy('name') as $country)
    <tr>
      <td>
        {{ $country->name }}
      </td>
      <td>
        {{ $country->code }}
      </td>
      <td>
        <img src="{{ $country->getFlagUrl() }}">        
      </td>
      <td>
        {{ $country->voter_name }}
      </td>
      <td>
        {{ $country->votes }}
      </td>
      <td>
        {{ $country->voting_complete ? 'true' : 'false' }}
      </td>
    </tr>
    @endforeach
    </tbody>
    </table>
</div>
@endsection