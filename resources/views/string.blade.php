@foreach($notes as $note)
<strong>{{ $note->getType()?->getName() }}:</strong> {{ $note->getText() }} <br />
@endforeach