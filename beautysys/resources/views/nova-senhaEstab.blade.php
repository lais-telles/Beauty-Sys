@extends('template')

@section('title', 'Redefinição de Senha')

@section('nav-buttons')
@endsection

@section('content')
<section class="d-flex" style="margin-top: 15rem; margin-bottom: 10rem;">
    <div class="container">
        <h1 class="fw-bold mb-0 fs-2">Redefinição de Senha</h1>
        <div>
            <form action="{{ route('definirNovaSenhaEstabelecimento') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-floating mb-3">
                    <input type="password" class="form-control rounded-3 @error('new_password') is-invalid @enderror" id="floatingNewPassword" name="new_password" placeholder="" required>
                    <label for="floatingNewPassword">Digite a nova senha</label>
                    @error('new_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Definir nova senha</button>
            </form>
        </div>
    </div>
</section>
@endsection
