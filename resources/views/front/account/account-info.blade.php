@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $indicateRequiredField = getStaticTranslation('general')['indicate_required_field_text'] ?? '';
        $previosApps=\App\Models\CustomerMessagingAppDetail::where('customer_id',$loggedInCustomer)->get();
        $messagingAppDetailIds = $previosApps->pluck('messaging_app_detail_id')->mapWithKeys(function ($id, $key) {
    return [$key => (string) $id];  // Ensuring it's a string and using the index as the key
})->toArray();
    @endphp
   
    {{-- <account-info logged_in_customer="{{ $loggedInCustomer }}" school_id="{{ $data['school'] }}" user="{{ Auth::guard('customers')->user() }}"></account-info> --}}
    <account-info 
    logged_in_customer="{{ $loggedInCustomer }}" 
    school_id="{{ $data['school'] }}" 
    :user='@json(Auth::guard("customers")->user())'
    indicate_required_field="{{ $indicateRequiredField }}"
    messaging_app="{{ json_encode($messagingAppDetailIds)  }}">
</account-info>
@endsection

