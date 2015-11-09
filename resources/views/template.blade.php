<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tariff</title>

	<link rel="stylesheet" href="{{ url('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/tariff.css') }}">

	<link href="{{ url('js/plugins/tag-it-master/css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ url('js/plugins/tag-it-master/css/tagit.ui-zendesk.css')}}" rel="stylesheet" type="text/css">

</head>
<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Tariff</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-left">
            <li><a href="#">Tariff</a></li>
            <li><a href="#">Historial</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
        </div>

 
      </div>
    </nav>
	
	<div class="container-fluid">
		

		<div class="row">
      <div class="col-sm-12">
	    		<form id="formSearch">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input name="tags" id="singleFieldTags2" value="">
	  
		  			<button type="submit" class="btn btn-default">Search</button>
				</form>
      </div>
    </div>
    
    <br>
    <div class="row">
      <div class="col-lg-8">
				<div id="result">
				</div>
			</div>
    </div>
		
	</div>
    
	<script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>

    <!-- The real deal -->
    <script src="{{ url('js/plugins/tag-it-master/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>

    <script>
        $(function(){

            var sampleTags = [];

            $.getJSON( "{{ url('array_search') }}", function( data ) {
              $.each( data, function( key, val ) {
                sampleTags.push(val);
              });
            });

            $('#singleFieldTags2').tagit({
            	autocomplete: {
            		delay: 0, 
            		minLength: 2,
            		autoFocus: true
            	},
            	singleFieldDelimiter: ';',
                availableTags: sampleTags,
                allowSpaces: true
            });
            
        });
    </script>

    <script>

    $(document).ready(function(){
        $("#formSearch").submit(function(e) {

            var url = "{{ url('get_result') }}"; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: { tags: $("#singleFieldTags2").val()},
                   success: function(data)
                   {
                       $("#result").html(data); // show response from the php script.
                   }
                 });

            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
    });
    
    </script>

  </body>
</html>