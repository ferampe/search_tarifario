<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th>Action</th>
			<th>Results</th>
		</tr>

		@foreach($services as $service)
		<tr>
			<td style="width:5%">
				<p><button type="button" class="btn btn-success btn-add" data-service-id="{{ $service->id}}">Add</button></p>
			</td>
			<td>
				<h4 style="margin-top:0px">{{$service->name_service}}</h4>
				<span class="label label-default">{{ strtoupper($service->name_country) }}</span> <span class="label label-default">{{ strtoupper($service->name_destination) }}</span>

				<span class="label label-default">Provider: {{ strtoupper($service->name_provider) }}</span> <span class="label label-default">{{ strtoupper($service->name_category) }}</span>


			</td>
			
			<!--<td><span class="label label-default">{{$service->id}}</span></td>
			<td>{{$service->name_country}}</td>
			<td><span class="label label-default">{{$service->name_destination}}</span></td>
			<td>{{$service->name_provider}}</td>
			<td>{{$service->name_category}}</td>
			<td>{{$service->name_service}}</td>-->
		</tr>
		@endforeach
	</table>
</div>