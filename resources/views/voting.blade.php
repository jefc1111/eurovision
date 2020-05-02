@extends('layout')

@section('title', 'Eurovision 2020 - voting')

@section('body')
<body class="bg-cloud">
  <div class="container">
  <span>
      <h1>Welcome, {{ $votingCountry->voter_name }}, representative of {{ $votingCountry->name }}
        <img class="float-right" src="{{ $votingCountry->getFlagUrl() }}">
      </h1>      
    </span>


    <div class="row">
      <div class="col-sm">
              <ul class="list-unstyled scores float-right">
      @foreach($scores as $score)
      <li class="">
        {{ $score }}
        
      </li>
      @endforeach  
    </ul>
      </div>
      <div class="col-sm">
      <ul class="list-unstyled countries float-left">
      @foreach($countries->sortBy('name') as $country)
      <li class="">
        {{ $country->name }}
        <img class="float-right" src="{{ $country->getFlagUrl() }}">
      </li>
      @endforeach  
    </ul>
      </div>
      <div class="col-sm">
        
      </div>
    </div>




  </div>
  <footer class="taskbar">
      <div class="row" style="margin-right: 0px;">
          <div class="col-8">
              <a href="#" class="btn start-button"><img src="assets/icons/windows_title-1.png" class="icon-16">Start</a>
          </div>
          <div class="col-4 time">
              <a href="#" class="btn start-button"><img src="assets/icons/usb-1.png" class="icon-16"></a>
          </div>
      </div>
    
  </footer>
</body>
@if(! $votingCountry->voting_complete)
<script>

$("ul").sortable();

</script>
@endif
<style>

li {
  padding: 0;
  height: 40px;  
  border: 1px solid black;
  padding: 5px;
  background: rgba(255,255,255,0.7);
}

ul.countries li {
  width: 400px;
}

ul.scores li {
  width: 60px;
}

li img {
  height: 32;
}

div.col-sm {
  padding: 0;
}
</style>

@endsection
