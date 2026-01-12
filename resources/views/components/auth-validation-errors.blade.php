@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">
            {{-- {{ __('Whoops! Something went wrong.') }} --}}
            {{-- <div class="relative tooltip -bottom-4 group-hover:flex" >
                <div role="tooltip"
                    class="relative tooltiptext -top-2 wfull z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-red-100 border border-primary text-gray-600 w_full md:w_half rounded ">
                    <p class="text-primary leading-none text-left text-sm lg:text-base">{{ __('Whoops! Something went wrong.') }}</p>
                </div>
            </div> --}}
        </div>

        <ul class="mt-3 list-none list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                {{-- <li>{{ $error }}</li> --}}
                <li>
                    <div class="relative tooltip -bottom-4 group-hover:flex" >
                        <div role="tooltip"
                            class="relative tooltiptext -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-red-100 border border-primary text-gray-600 w_full w-fit md:w_half rounded ">
                            <p class="text-primary leading-none text-left text-sm lg:text-base">
                                {{-- {{ $error }} --}}
                                The provided credentials do not match our records</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
