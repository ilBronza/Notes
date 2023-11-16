@if(count($notes))
<script type="text/javascript">
	$("table.{{ $key }} form").submit(function (event)
	{
		var that = this;
		event.preventDefault();
		var url = $(this).attr('action');

		var formData = {
			_method : 'DELETE'
		};

		$.ajax({
			type: "POST",
			url: url,
			data: formData,
			dataType: "json",
		}).done(function (response)
		{
			if(response.success == true)
			{
				window.addSuccessNotification(response.message)

				$(that).parents('.ibfetchercontainer').find('.refresh').click();
			}
		});

	});
</script>

<table class="uk-width-1-1 uk-table {{ $key }}">
	@foreach($notes as $note)
	<tr>
		<td style="width: 47px;" class="uk-visible@l">
			<a href="{{ $note->getEditUrl() }}" uk-icon="file-edit"></a>
		</td>
		<td class="uk-visible@l">{{ $note->getType()?->getName() }}</td>
		<td class="uk-visible@l"><strong>{{ $note->getUserName() }} - {{ $note->getLastCompilationDate() }}: </strong></td>
		<td>{{ $note->getText() }}</td>
		<td>
			<ul class="uk-list">
			@foreach($note->getImages() as $file)
				<li uk-lightbox>
					<a
				        data-type="iframe"
						href="{{ $file->getServeImageUrl() }}?iframed=true"
						>

						@if($file->isImage())
							<img style="max-width: 100px; max-height: 60px;" src="{{ $file->getUrl() }}" />
						@else
						<span uk-icon="file">
							{{ $file->name }}
						</span>
						@endif
					</a>
				</li>
			@endforeach
			</ul>
		</td>
		<td style="width: 47px;">
		@if($note->canBeArchived())
			{!! $note->getArchiveButton() !!}
		@endif
		</td>
		<td style="width: 47px;">
		@if($note->canBeDeleted())
			{!! $note->getDeleteButton() !!}
		@endif
		</td>
	</tr>
	@endforeach
</table>
{{-- @else
{{ __('notes::notes.anyNoteIsPresent') }} --}}
@endif