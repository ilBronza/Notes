
@if(count($notes))
<table class="uk-width-1-1">
	@foreach($notes as $note)
	<tr>
		<td>{{ $note->noteable?->getTranslatedClassname() }}</td>
		<td>{{ $note->noteable?->getName() }}</td>
		<td>{{ $note->getType()?->getName() }}</td>
		<td><strong>{{ $note->getUserName() }} - {{ $note->getLastCompilationDate() }}: </strong></td>
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
		@if(\Auth::user()?->hasRole('administrator'))
		<td>
			<a
				data-type="POST"
				class="ib-cell-ajax-button"
				href="{{ $note->getArchiveUrl() }}">
				<i class="fa fa-archive" aria-hidden="true"></i>
			</a>
		</td>
		<td>
			<a
				data-type="PUT"
				class="ib-cell-ajax-button"
				href="{{ $note->getSeenUrl() }}">
				<i class="fa fa-eye" aria-hidden="true"></i>
			</a>
		</td>
		@endif
	</tr>
	@endforeach
</table>
{{-- @else
{{ __('notes::notes.anyNoteIsPresent') }} --}}
@endif