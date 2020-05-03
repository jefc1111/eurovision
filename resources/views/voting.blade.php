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
      <li id="country-{{ $country->id }}" data-id="{{ $country->id }}" class="">
        {{ $country->name }}
        <img class="float-right" src="{{ $country->getFlagUrl() }}">
      </li>
      @endforeach
    </ul>
      </div>
      <div class="col-sm">

      </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit scores</button>
    <img class="float-right spinner" src="assets/icons/network_internet_pcs_installer-2.png">
    <span id="data-saving" class="float-right">Saving...</span>
    <span id="data-saved" class="float-right">All data saved</span>
    <span id="data-error" class="float-right">Error saving data - please contact Paul</span>
    

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

$("ul").sortable({
  stop: function(e, ui) {
      const positionData = $('ul.countries li').toArray().map((item) => $(item).data("id"));

      $(".spinner").addClass("spin");

      $("span#data-saved").hide();

      $("span#data-saving").show();

      $.post("/save-position-data/{{ $votingCountry->id }}", {
        positionData
      }).done(function(rdata) {


        $(".spinner").removeClass("spin");

        $("span#data-saved").show();    

        $("span#data-saving").hide();
      }).fail(function(xhr, status, error) {
        console.log(error);

        $(".spinner").removeClass("spin");

        $("span#data-error").show();    

        $("span#data-saving").hide();
      });
  }
});

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

span#data-saving, span#data-error {
  display: none;  
}

.spin {  
  animation-name: spin;
  animation-duration: 1500ms;
  animation-iteration-count: infinite;
  animation-timing-function: linear; 
  /* transform: rotate(3deg); */
   /* transform: rotate(0.3rad);/ */
   /* transform: rotate(3grad); */ 
   /* transform: rotate(.03turn);  */
}

@keyframes spin {
    from {
        transform:rotate(0deg);
    }
    to {
        transform:rotate(360deg);
    }
}
</style>

@endsection
