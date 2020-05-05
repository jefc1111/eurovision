@extends('layout')

@section('title', 'Eurovision 2020 - private admin')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('body')
<body class="bg-cloud">
  <div class="container-fluid">
    <table class="table table-bordered table-sm table-dark">
      <thead>
        <th>Id</th>
        <th>Flag</th>
        <th>Name</th>
        <th>Secret code</th>
        <th>Song name</th>
        <th>Sequence number</th>        
        <th>Voter name</th>
        <th>Vote data</th>
        <th>Can be voted for</th>
        <th>Voting complete</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($countries->sortBy('name') as $country)
        <tr class="{{ $country->highlight ? 'bg-success' : null }}">
          <td>
            {{ $country->id }}
          </td>
          <td>
            <img height="32" src="{{ $country->getFlagUrl() }}">
          </td>
          <td>
            {{ $country->name }}
          </td>
          <td>
            {{ $country->code }}
          </td>
          <td>
            {{ $country->song_name }}
          </td>
          <td>
            {{ $country->song_seq }}
          </td>
          <td>
            {{ $country->voter_name }}
          </td>
          <td>
            {{ $country->votes }}
          </td>
          <td>
            {{ $country->votable ? 'true' : '' }}
          </td>
          <td>
            {{ $country->voting_complete ? 'true' : '' }}
          </td>
          <td>
            <a class="btn btn-light btn-xs" href="/highlight/{{ $country->id }}">highlight</a>
          </td>
        </tr>
        @endforeach
        </tbody>        
      </table>
      <a class="btn btn-light btn-xs" href="/remove-highlight">Remove highlights</a>
  </div>
</body>

<style>

</style>

@endsection
