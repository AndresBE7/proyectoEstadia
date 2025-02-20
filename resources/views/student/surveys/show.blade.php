@extends('layouts.app')

@section('content')
<h1>{{ $survey->title }}</h1>
<p>{{ $survey->description }}</p>

<form action="{{ route('students.surveys.submit', $survey->id) }}" method="POST">
    @csrf
    @foreach(json_decode($survey->questions) as $question)
        <label>{{ $question }}</label>
        <input type="number" name="answers[]" min="0" max="5" required>
    @endforeach
    <button type="submit" class="btn btn-primary">Enviar Respuestas</button>
</form>
@endsection
