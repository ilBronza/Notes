@extends('uikittemplate::app')

@section('content')

<style type="text/css">
	.fetchertitle
	{
		font-weight: bold;
	}
</style>

<div class="uk-card uk-card-default">
	<div class="uk-card-header">
		<span class="uk-h3">
			Stai aggiungendo una nota per l'elemento {!! __('notes.crudModels' . $subject->getCamelcaseClassBasename()) !!}
		</span>
	</div>
	<div class="uk-card-body">

		<div>{!! Notes::getFetcher($subject) !!}</div>		
	</div>

	@if(count($elements) > 0)
	<div class="uk-card-footer">
		<span class="uk-h3">
			Ma potresti volerla inserire per uno dei suoi elementi correlati:
		</span>
	</div>
	<div class="uk-card-footer">
		
		@foreach($elements as $name => $element)

		@if(class_basename($element) == 'Collection')
			@foreach($element as $_element)
			<div class="uk-margin-top">{!! Notes::getFetcher($_element) !!}</div>
			@endforeach	
		@else
		<div>{!! Notes::getFetcher($element) !!}</div>
		@endif

		@endforeach

		
	</div>

	@endif
</div>


@endsection