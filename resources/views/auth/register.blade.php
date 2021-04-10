<x-guest-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <x-auth-card>

        <x-slot name="logo">
            <a href="/">
                <img src = "{{ asset('images/task_manager.svg') }}" style="width:100px;height:100px;">
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <b class="text-xs text-red-500">Every field is required.</b>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')"/>

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <input id='chkbx' type="checkbox" name="check_box" onclick="generate(this.form)">
            Check this box if you want auto generated id.<br><br>

            <label for='user_id'>User Id</label>
            <input id="auto_id" name='user_id' type='text' class="rounded w-full"><br><br>

            <label for='phone_number'>Phone Number</label>
            <input name='phone_number' type='text' required='true' class="rounded w-full"><br><br>

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div><br>

            <label for='address'>Address</label>
            <input name='address' type='text' required='true' class="rounded w-full"><br><br>

            <label for='designation'>Designation</label>
            <input name='designation' type='text' required='true' class="rounded w-full"><br><br>

            <div class="flex justify-start">
                <label for="role">Role -&nbsp;</label>
                <span>
                    <input type="radio" id="admin" name="role" value="admin">
                    <label for="admin">&nbsp;Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><br>
                </span>
                <span>
                    <input type="radio" id="local" name="role" value="local">
                    <label for="local">&nbsp;Local&nbsp;</label><br>
                </span>
            </div><br>

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
        <script type="text/javascript">
            function generate(f) {
                if(f.check_box.checked == true) {
                    var str = f.name.value;
                    var matches = str.match(/\b(\w)/g);
                    var acronym = matches.join('');
                    acronym = acronym.toUpperCase();
                    var str1 = "User_";
                    f.user_id.value = str1.concat(acronym);
                }
                else if(f.check_box.checked == false){
                $('#auto_id').val("");
            }
            }
        </script>
    </x-auth-card>
</x-guest-layout>
