
@if(count($notes))
<table class="uk-width-1-1">
	@foreach($notes as $note)
	<tr>
		<td><strong>{{ $note->getUserName() }} - {{ $note->getLastCompilationDate() }}: </strong></td>
		<td>{{ $note->getText() }}</td>
		<td>{{ $note->getType() }}</td>
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
	</tr>
	@endforeach
</table>
@else
{{ __('notes::notes.anyNoteIsPresent') }}
@endif