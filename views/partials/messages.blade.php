@if(isset($errorMessage))
    <div class="alert alert-danger">
        {{ $errorMessage }}
    </div>
@endif

@if(Input::get('errorMessage'))
    <div class="alert alert-danger">
        {{ Input::get('errorMessage') }}
    </div>
@endif

@if(isset($successMessage))
    <div class="alert alert-success">
        {{ $successMessage }}
    </div>
@endif

@if(Input::get('successMessage'))
    <div class="alert alert-success">
        {{ Input::get('successMessage') }}
    </div>
@endif

@if(isset($warningMessage))
    <div class="alert alert-warning">
        {{$warningMessage}}
    </div>
@endif

@if(Input::get('warningMessage'))
    <div class="alert alert-warning">
        {{ Input::get('warningMessage') }}
    </div>
@endif