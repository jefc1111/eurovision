@extends('layout')

@section('title', 'Eurovision 2020 - private admin')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('body')
<body class="bg-cloud">
  <div class="container">
    <table class="table table-bordered">
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
      </thead>
      <tbody>
        @foreach($countries->sortBy('name') as $country)
        <tr>
          <td>
            {{ $country->id }}
          </td>
          <td>
            <img src="{{ $country->getFlagUrl() }}">
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
            {{ $country->votable ? 'true' : 'false' }}
          </td>
          <td>
            {{ $country->voting_complete ? 'true' : 'false' }}
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
