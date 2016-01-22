<li data-item-id="{{ $service->id }}" class="li-item list-group-item">
	
	
	
	<div class="info-item">
		{{ $service->name_service}}<br/>
		<span class="label label-default">{{ strtoupper($service->name_country) }}</span> 
		<span class="label label-default">{{ strtoupper($service->name_destination) }}</span>
		<span class="label label-default">Provider: {{ strtoupper($service->name_provider) }}</span>
		<span class="label label-default">{{ strtoupper($service->name_category) }}</span>
	</div>
	

	<button class="btn btn-xs btn-danger removeImg">
       <span class="glyphicon glyphicon-trash"></span>
    </button>
</li>