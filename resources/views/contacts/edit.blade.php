@extends('layout')

@section('headding')
Editar Contato
@endsection

@section('content')
<form>
    <div class='mb-3'>
        <label class='form-label'>Nome</label>
        <input class='form-control' value={{$contact->data->fullname}} name='fullname'/>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Telefone</label>
        <input class='form-control' value="{{$contact->data->phone}}" name='phone'/>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Anotação</label>
        @if($contact->data->note == null)
            <input class='form-control' value='' name='note'/>
        @else
            <input class='form-control' value="{{$contact->data->note}}" name='note'/>
        @endif
    </div>
    <div class='mb-3'>
        <label class='form-label'>Categoria</label>
        <input class='form-control' value={{$contact->data->id_category}} name='category'/>
    </div>

    <button class='btn btn-success mb-3 ' type='submit'>Salvar Contato</button>
</form>
@endsection
