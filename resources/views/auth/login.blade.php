<x-guest-layout>
    <div class='bg-blue-900 dark:bg-gray-900'>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>
    
            <x-jet-validation-errors class="mb-4 alert alert-danger" />
    
            @if(session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif
    
            <form method="POST" action="{{ route('login') }}" x-data="{
                email: '{{ old('email', 'admin@site.test') }}',
                password: 'password',
            }" novalidate>
                @csrf
                @php
                    // TODO remove fake email and password
                @endphp
                <div>
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" class="block w-full mt-1 auth" type="email" name="email" x-model='email' required
                        autofocus />
                    <p class='pt-2 text-red-400' x-show="!$store.common.testMail(email)" x-cloak>
                        {{__('validation.email', [
                            'attribute' => 'Email Address'
                        ])}}
                    </p>
                </div>
    
                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input id="password" class="block w-full mt-1 auth" type="password" name="password" x-model='password'
                        minlength='8' required autocomplete="current-password" />
                    <p class='pt-2 text-red-400' x-show="password.length < 8" x-cloak>
                        {{__('validation.min', [
                            'attribute' => 'Password',
                            'min' => 8
                        ])['string']}}
                    </p>
                </div>
    
                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                        <span class="ml-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>
    
                <div class="flex items-center justify-end mt-4">
                    @if(Route::has('password.request'))
                        <a class="text-sm text-gray-300 underline hover:text-gray-400"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
    
                    <x-jet-button class="ml-4" type='submit' bg='green'
                        x-bind:disabled="!email.length || password.length < 8 || !$store.common.testMail(email)">
                        {{ __('Login') }}
                    </x-jet-button>
                </div>
            </form>
            <div class="p-2 mt-3 rounded" style="background-color: rgba(0, 0, 0, 0.3);">
                <pre>
email => admin@site.test
email => super@site.test
email => user@site.test

---
password => password
                </pre>
            </div>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
