@include('system::partials.validation')

{{ Form::resource($model, "admin.$resourceName", ['files' => true]) }}

    @include($formContentView)

    {{ Form::submit($model->exists ? 'Editar' : 'Cadastrar', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}
