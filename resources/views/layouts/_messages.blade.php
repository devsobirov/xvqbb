<div class="d-flex flex-column" style="position: fixed; right: 10px; top: 50px; z-index: 9999; max-width:80%; width:auto;">
    @if ($errors->any())
        @foreach($errors->all() as $message)
            <x-alert :class="'danger'" :message="$message"></x-alert>
        @endforeach
    @endif

    @if ($message = session()->get('msg'))
        <x-alert :class="'danger'" :message="$message"></x-alert>
    @endif
    @if ($message = Session::get('success'))
        <x-alert :class="'success'" :message="$message"></x-alert>
    @endif

    <template x-show="$store.messages.errors && $store.messages.errors.length"
        x-for="(message, key) in $store.messages.errors"
        x-cloak
    >
        <div class="alert alert-danger alert-dismissible mb-2" x-transition :key="key">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                    </svg>
                </div>
                <div x-text="message"></div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </template>

    <template x-show="$store.messages.success && $store.messages.success.length"
        x-for="(message, key) in $store.messages.success"
        x-cloak
    >
        <div class="alert alert-success alert-dismissible mb-2" x-transition :key="key">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                    </svg>
                </div>
                <div x-text="message"></div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </template>
</div>
