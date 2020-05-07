@extends('layout')

@section('title', 'Eurovision 2020 - voting')

@section('body')
<body class="bg-cloud">
  <div class="container">
    <span>
      <h2>Welcome, {{ $votingCountry->voter_name }}, representative of {{ $votingCountry->name }}
        <img class="float-right" src="{{ $votingCountry->getFlagUrl() }}">
      </h2>
    </span>
    @if($votingCountry->voting_complete)
    <h2>
      We have received your final scores.
      <img src="assets/icons/check-0.png">
    </h2>
    @endif
    <div class="row">
      <div class="col-sm">
        <ul class="list-unstyled scores float-right">
          @foreach($scores as $score)
          <li class="font-weight-bold">
              {{ $score }}
          </li>
          @endforeach
        </ul>
      </div>
    <div class="col-sm">
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
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmation-modal">
        Submit final scores
    </button>
    @endif
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

<!-- Modal -->
<div class="modal" id="confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <p><img src="assets/icons/floppy_drive_5_25-3.png" class="icon-32"></p>
              <p>Are you sure you want to submit your scores?</p>                
              <p>This cannot be undone.</p>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <button id="submit-scores"  type="button" class="btn btn-primary" data-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>

@if(! $votingCountry->voting_complete)
<script>

$("ul.countries").sortable({
  cursor: "grabbing",
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

$("#submit-scores").click(function() {
  $.get("/submit-scores/{{ $votingCountry->id }}", function() {
    location.reload();
  });
});

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

/*!
 * jQuery UI Touch Punch 0.2.3
 *
 * Copyright 2011–2014, Dave Furfero
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Depends:
 *  jquery.ui.widget.js
 *  jquery.ui.mouse.js
 */
!function(a){function f(a,b){if(!(a.originalEvent.touches.length>1)){a.preventDefault();var c=a.originalEvent.changedTouches[0],d=document.createEvent("MouseEvents");d.initMouseEvent(b,!0,!0,window,1,c.screenX,c.screenY,c.clientX,c.clientY,!1,!1,!1,!1,0,null),a.target.dispatchEvent(d)}}if(a.support.touch="ontouchend"in document,a.support.touch){var e,b=a.ui.mouse.prototype,c=b._mouseInit,d=b._mouseDestroy;b._touchStart=function(a){var b=this;!e&&b._mouseCapture(a.originalEvent.changedTouches[0])&&(e=!0,b._touchMoved=!1,f(a,"mouseover"),f(a,"mousemove"),f(a,"mousedown"))},b._touchMove=function(a){e&&(this._touchMoved=!0,f(a,"mousemove"))},b._touchEnd=function(a){e&&(f(a,"mouseup"),f(a,"mouseout"),this._touchMoved||f(a,"click"),e=!1)},b._mouseInit=function(){var b=this;b.element.bind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),c.call(b)},b._mouseDestroy=function(){var b=this;b.element.unbind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),d.call(b)}}}(jQuery);

</script>
@endif
<style>

li {
  padding: 0;
  height: 32px;
  border: 1px solid #ccc;
  padding: 2px;
  background: rgba(255,255,255,0.7);
}

ul.countries li {
  width: 500px;
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
