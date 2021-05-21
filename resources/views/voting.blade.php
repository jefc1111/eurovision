@extends('layout')

@section('title', 'Eurovision 2021 - voting')

@section('body')
<body class="voting-bg">
  <div class="container">
    <div class="row">
      <span>
        <h3>Welcome, {{ $votingCountry->voter_name }}, representative of {{ $votingCountry->name }}
          <img id="voter-flag" class="float-right" src="{{ $votingCountry->getFlagUrl() }}">
        </h3>
      </span>
      @if($votingCountry->voting_complete)
      <h3>
        We have received your final scores.
        <img src="{{ asset('assets/icons/check-0.png') }}">
      </h3>
      @endif
      @if(! $votingAllowed)
      <h4>
        Thank you for logging in! Voting is not open yet. Please refresh the page when asked. 
        <img src="{{ asset('assets/icons/no-1.png') }}">
      </h4>
      @endif
    </div>
    @if($votingAllowed)    
    <i style="font-size: 0.8em; font-weight: 1000;" class="bi bi-arrow-90deg-down"></i>&nbsp;&nbsp;<span>Points awarded</span><br>
    <div class="row">
      <div class="col-xs">        
        <ul class="list-unstyled scores float-right">
          @foreach($scores as $score)
          <li class="font-weight-bold">
              {{ $score }}
          </li>
          @endforeach
        </ul>
      </div>
    <div class="col-xs">
      <ul class="list-unstyled countries float-left">
        @foreach($countries as $country)
        <li id="country-{{ $country->id }}" data-id="{{ $country->id }}">
          <span class="font-weight-bold">
            {{ $country->name }}
            <img class="float-right" src="{{ $country->getFlagUrl() }}">
          </span>
          <span class="country-details">
            "{{ $country->song_name }}" (Song {{ $country->song_seq }})            
          </span>
          <span class="now-playing" style="padding: 5px 4px 0 0; float: right; display: none;">
            <i class="bi bi-music-note-list"></i>
          </span>
        </li>
        @endforeach
      </ul>
    </div>
    @endif
      <div class="col-sm">

      </div>
    </div>
    @if($votingAllowed)
    @if(! $votingCountry->voting_complete)
    <button disabled id="trigger-confirmation-modal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmation-modal">
        Submit final scores <i class="bi bi-check2-all"></i>
    </button>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <img id="save-spinner" src="https://static.eurovision.tv/dist/assets/images/esc_trophy.c18806541a73cace837abd353b64f12c.svg" class="spinner">
    <span id="data-saving" class="">Saving...</span>
    <span id="data-saved" class="">Votes saved</span>
    <span id="data-error" class="">Error saving data - please contact Paul</span>
    @else
    <div class="row">
      <div>
        <p>
          Voting app built by <a target="_blank" href="https://github.com/jefc1111">Geoff</a>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a class="" target="_blank" href="https://www.buymeacoffee.com/jefc1111">Buy me a coffee! <i class="bi bi-cup"></i></a>
        </p>
      </div>
    </div>
    @endif  
    @endif
  </div>
  <footer class="taskbar">
      <div class="row" style="margin-right: 0px;">
          <div class="col-8">
              
          </div>
          <div class="col-4 time">
              
          </div>
      </div>
  </footer>
</body>

<!-- Modal -->
<div class="modal" id="confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Final score submission</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <p><img src="{{ asset('assets/icons/floppy_drive_5_25-3.png') }}" class="icon-32"></p>
              <p>Are you sure you want to submit your scores?</p>                
              <p>This cannot be undone.</p>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <a href="/submit-scores/{{ $votingCountry->id }}" id="submit-scores" class="btn btn-primary">Submit</a>
            </div>
        </div>
    </div>
</div>


<script>
@if(! $votingCountry->voting_complete & $votingAllowed)
$("ul.countries").sortable({
  cursor: "grabbing",
  stop: function(e, ui) {
    const positionData = $('ul.countries li').toArray().map((item) => $(item).data("id"));

    $("#trigger-confirmation-modal").prop("disabled", true);

    $(".spinner").addClass("spin");

    $("span#data-saved").hide();

    $("span#data-saving").show();

    $.post("/save-position-data/{{ $votingCountry->id }}", {
      positionData
    }).done(function(rdata) {
      $(".spinner").removeClass("spin");

      $("#trigger-confirmation-modal").prop("disabled", false);

      $("span#data-saved").show();    

      $("span#data-saving").hide();
    }).fail(function(xhr, status, error) {
      console.log(error);

      $("#trigger-confirmation-modal").prop("disabled", false);

      $(".spinner").removeClass("spin");

      $("span#data-error").show();    

      $("span#data-saving").hide();
    });
  }
});

@endif

function doPoll() {
    $.post('/vote-page-poll', function(data) {
        const highlightedCountries = data.filter(c => c.highlight);

        $("ul.countries li").removeClass("highlighted");

        $(".now-playing").hide();

        highlightedCountries.forEach(c => {
          $("ul.countries li[data-id=" + c.id + "]").addClass("highlighted");

          $("ul.countries li[data-id=" + c.id + "]").find(".now-playing").show();
        });

        setTimeout(doPoll,5000);
    });
}

doPoll();

</script>

<style>
@if($votingCountry->voting_complete)
ul li:nth-child(1) {
  background: gold;
  color: black;
}
/*
ul li:nth-child(2) {
  background: #aaa9ad;
}
ul li:nth-child(3) {
  background: rgb(205, 127, 50);
}
ul li:nth-child(-n+3) {
  color: black;
}
*/
@endif

li {
  padding: 0;
  height: 32px;
  border-style: solid;
  border-width: 1px 1px 0 0;
  border-color: black;
  padding: 2px;
  background: #174ebe;
}

ul.scores li {
  padding-right: 8px;
  text-align: right;
}

ul.countries li {
  padding: 3px 8px;
  width: 100%;
  max-width: 500px;
}

ul.countries li:hover {
  @if(! $votingCountry->voting_complete)
  cursor: grab;
  @endif
}

ul.scores li {
  width: 40px;
}

ul.countries li {
  width: 400px;
}

div.col-sm {
  padding: 0;
}

span#data-saving, span#data-error {
  display: none;  
}

.spin {  
  animation-name: spin;
  animation-duration: 500ms;
  animation-iteration-count: infinite;
  animation-timing-function: linear; 
  /* transform: rotate(3deg); */
   /* transform: rotate(0.3rad);/ */
   /* transform: rotate(3grad); */ 
   /* transform: rotate(.03turn);  */
}

.country-details {
  font-size: 0.85rem;
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
