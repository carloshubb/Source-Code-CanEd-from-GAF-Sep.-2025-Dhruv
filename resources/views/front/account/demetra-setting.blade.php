@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $schoolDemetraSetting =App\Models\SchoolDemetraSetting::with('sports','communityServices','activities')->where('school_id',Auth::guard('customers')->user()->school->id)->first();
    @endphp
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full p-2">
        <demetra-setting school_id="{{ $data['school'] }}" school_demetra_setting="{{$schoolDemetraSetting}}" logged_in_customer="{{ $loggedInCustomer }}"></demetra-setting>
    </div>
@endsection
