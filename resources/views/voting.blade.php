@extends('layout')

@section('title', 'Eurovision 2020 - voting')

@section('body')
<body class="bg-cloud">
  <div class="container">
    <div class="row">
      <span>
        <h3>Welcome, {{ $votingCountry->voter_name }}, representative of {{ $votingCountry->name }}
          <img class="float-right" src="{{ $votingCountry->getFlagUrl() }}">
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
        </li>
        @endforeach
      </ul>
    </div>
      <div class="col-sm">

      </div>
    </div>
    @if(! $votingCountry->voting_complete)
    <button disabled id="trigger-confirmation-modal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmation-modal">
        Submit final scores
    </button>
    @endif
    <img src="{{ asset('assets/icons/network_internet_pcs_installer-2.png') }}" class="float-right spinner">
    <span id="data-saving" class="float-right">Saving...</span>
    <span id="data-saved" class="float-right">All data saved</span>
    <span id="data-error" class="float-right">Error saving data - please contact Paul</span>
  </div>
  <footer class="taskbar">
      <div class="row" style="margin-right: 0px;">
          <div class="col-8">
              <a href="#" class="btn start-button"><img src="{{ asset('assets/icons/windows_title-1.png') }}" class="icon-16">Start</a>
          </div>
          <div class="col-4 time">
              <a href="#" class="btn start-button"><img src="{{ asset('assets/icons/usb-1.png') }}" class="icon-16"></a>
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

        $("ul.countries li").removeClass("bg-success");

        highlightedCountries.forEach(c => {
          $("ul.countries li[data-id=" + c.id + "]").addClass("bg-success");
        });

        setTimeout(doPoll,5000);
    });
}

doPoll();

</script>

<style>
@if($votingCountry->voting_complete)
ul li:nth-child(-n+3) {
  background: yellow;
}
@endif

li {
  padding: 0;
  height: 32px;
  border: 1px solid #ccc;
  padding: 2px;
  background: rgba(255,255,255,0.7);
}

ul.countries li {
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

li img {
  height: 28;
}

div.col-sm {
  padding: 0;
}

span#data-saving, span#data-error {
  display: none;  
}

.spin {  
  animation-name: spin;
  animation-duration: 300ms;
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
