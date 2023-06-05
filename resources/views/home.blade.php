@extends('layouts.app')

@section('custom_styles')

@endsection

@section('content')
    <div class="page-body">
        <div class="container-xl">

            <div class="alert alert-success">
                <div class="alert-title">
                    {{ __('Welcome') }} {{ auth()->user()->name ?? null }}
                </div>
                <div class="text-muted">
                    {{ __('You are logged in!') }}
                </div>

                @if(!auth()->user()->telegram_chat_id)
                    <a href="{{route('telegram.start')}}" target="_blank" class="btn btn-info">Subscribe to telegram</a>
                @endif
            </div>

        </div>
    </div>
@endsection
