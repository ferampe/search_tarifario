<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tariff</title>

	<link rel="stylesheet" href="{{ url('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/tariff.css') }}">

	<link href="{{ url('js/plugins/tag-it-master/css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ url('js/plugins/tag-it-master/css/tagit.ui-zendesk.css')}}" rel="stylesheet" type="text/css">

  <style>
    body{
      background-color: #E6E6E6;
    }

    ul {
      padding-left: 0px;
    }

    .li-imte span {
      position: relative;
    }

    .removeImg {  
      position: absolute;
      top: 3px;
      right: 3px;
    }

    .label {
      
      font-size: 65%;
      color: #ddd;
    }

    /*.info-item{
      padding-left: 15px;
    }*/
  </style>

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
            <button type="button" class="btn btn-default" id="btn-clear">Clear</button>
				</form>
      </div>
    </div>


    
    <br>
    <div class="row" id="row-items">
      <div class="col-lg-6" id="col-result">
				<div id="result">
				</div>
			</div>

      <div class="col-lg-6" id="section-items">
        <h5>Items</h5>
        <ul id="items" class="sortable">
          
        </ul>
      </div>
    </div>
		
	</div>
    
	<script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ url('bower_components/bootstrap-waitingfor/src/waitingfor.js') }}"></script>
  <script src="{{ url('bower_components/bootstrap-html5sortable/jquery.sortable.min.js') }}"></script>

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

        var url = "{{ url('get_result') }}";

        $.ajax({
               type: "GET",
               url: url,
               data: { tags: $("#singleFieldTags2").val()},
               beforeSend: function(){
                  waitingDialog.show('Getting Information');
               },
               success: function(data)
               {
                   
                if($("#col-result").length == 0)
                {
                  //alert("se creara resultados");
                  $("#row-items").prepend('<div class="col-lg-6" id="col-result"><div id="result"></div></div>');
                  $("#section-items").removeClass('col-lg-12').addClass('col-lg-6');
                }

                $("#result").html(data); 

                waitingDialog.hide();

               }
             });

        e.preventDefault();
      });

      $(document).on('click', '.removeImg', function(){
        $(this).parent('li').remove();
      });

      $(document).on('click', '.btn-add', function(){
        var url = "{{ url('get_item') }}";
        var token = "{{ csrf_token() }}";

        $.ajax({
               type: "POST",
               url: url,
               data: { id: $(this).data('service-id'), _token: token },
               beforeSend: function(){
                  waitingDialog.show('Getting Information');
               },
               success: function(data)
               {
                   
                $("#items").append(data); 

                waitingDialog.hide();

               },
               error:function(){
                waitingDialog.hide();
                alert("Error");
                
               }
             });


      });

      $("#btn-clear").click(function(){
          if($("#col-result").length > 0)
          {
            //alert("se eliminara resultados");
            $("#col-result").remove();
            $("#section-items").removeClass('col-lg-6').addClass('col-lg-12');
          }
      });



      $('.sortable').sortable({
          placeholderClass: 'sortImg'
      });


  });
  
  </script>

  </body>
</html>