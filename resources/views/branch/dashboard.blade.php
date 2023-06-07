@extends('layouts.app')

@section('content')
    <div class="page-body">
        <div class="container-xl">

            <div class="alert alert-success">
                <div class="alert-title">
                    Hush kelibsiz {{ auth()->user()->name ?? null }}
                </div>
                <div class="text-muted">
                    Sizning filial: {{auth()->user()->branch?->name}}
                </div>
            </div>

            @if(!auth()->user()->telegram_chat_id)
                <x-subscription-card>
                    <x-subscription-action></x-subscription-action>
                </x-subscription-card>
            @endif

            <div class="row row-cards mt-3">
                <div class="col-md-6 col-sm-12">
                    <div class="card shadow {{count($tasks) ? 'bg-transparent' : ''}}" style="max-height: 28rem; height: auto">
                        <div class="card-header justify-content-between bg-white">
                            <div>Aktiv topshiriqlar ({{count($tasks)}})</div>
                        </div>
                        <div class="card-body card-body-scrollable card-body-scrollable-shadow px-0 px-2">
                            <div class="divide-y bg-transparent">
                            @forelse($tasks as $item)
                                <x-process-card :task="$item"></x-process-card>
                            @empty
                                <div class="px-3">Aktiv topshiriqlar mavjud emas</div>
                            @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <x-notifications></x-notifications>
                </div>
            </div>
        </div>
    </div>
@endsection
