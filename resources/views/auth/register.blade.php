<x-guest-layout>
    <div class='bg-blue-900 dark:bg-gray-900'>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}" x-data="{
            name: '{{ old('name') }}',
            email: '{{ old('email') }}',
            password: '',
            conf: '',
            dirtyName: false,
            dirtyMail: false,
            dirtyPass: false,
            dirtyConf: false,
        }" x-init="() => {
            $watch('name', () => dirtyName = true);
            $watch('email', () => dirtyMail = true);
            $watch('password', () => dirtyPass = true);
            $watch('conf', () => dirtyConf = true);
        }" novalidate>
                @csrf

                <div>
                    <x-jet-input id="name" class="block mt-1 w-full auth" type="text" name="name" x-model='name'
                        placeholder="{{ __('Name') }}" required autofocus autocomplete="name" />
                    <p class='pt-2 text-red-400'>
                        @error('name')
                            {{ $message }}
                        @enderror
                        <span x-show='name.length < 4 && dirtyName'>
                            {{__('validation.min', [
                                'attribute' => 'User Name',
                                'min' => 4,
                            ])['string']}}
                        </span>
                    </p>
                </div>

                <div class="mt-4">
                    <x-jet-input id="email" class="block mt-1 w-full auth" type="email" name="email" x-model='email'
                        placeholder="{{ __('Email') }}" required />
                    <p class='pt-2 text-red-400'>
                        @error('email')
                            {{ $message }}
                        @enderror
                        <span x-show='!$store.common.testMail(email) && dirtyMail'>
                            {{__('validation.email', [
                                'attribute' => 'Email Address',
                            ])}}
                        </span>
                    </p>
                </div>

                <div class="mt-4">
                    <x-jet-input id="password" class="block mt-1 w-full auth" type="password" name="password"
                        x-model='password' placeholder="{{ __('Password') }}" required
                        autocomplete="new-password">
                    </x-jet-input>
                    <p class='pt-2 text-red-400'>
                        @error('password')
                            {{ $message }}
                        @enderror
                        <span x-show='password.length < 8 && dirtyPass'>
                            {{__('validation.min', [
                                'attribute' => 'Password',
                                'min' => 8,
                            ])['string']}}
                        </span>
                    </p>
                </div>

                <div class="mt-4">
                    <x-jet-input id="password_confirmation" class="block mt-1 w-full auth" type="password"
                        name="password_confirmation" x-model='conf'
                        placeholder="{{ __('Confirm Password') }}" required
                        autocomplete="new-password" />
                    <p class='pt-2 text-red-400'>
                        @error('password_confirmation')
                            {{ $message }}
                        @enderror
                        <span x-show='conf !== password && dirtyConf'>
                            {{__('validation.same', [
                            'attribute' => 'Password',
                            'other' => 'Confirm Password'
                        ])}}
                        </span>
                    </p>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-300 hover:text-gray-400"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-jet-button class="ml-4" bg='teal' type='submit'
                        x-bind:disabled="name.length < 4 || !$store.common.testMail(email) || password.length < 8 || password !== conf">
                        {{ __('Register') }}
                    </x-jet-button>
                </div>
            </form>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
