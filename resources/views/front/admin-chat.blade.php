@extends('front.layouts.app')
@section('content')
<?php $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : ''; ?>
    <div class="bg-white container mx-auto">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 py-2 border-primary mt-6 w-full">
                <h1 class="can-edu-h1">Chat with Proxima Study</h1>
            </div>
        </div>

        <div class="my-10">
            <p class="font-medium">Hey Student,</p>
            <p>Use this page to communicate with us if you need a personalized service. Proxima Study and our partners offer a wide range of paid services.</p>
            <p>Please describe your needs, circumstances, and expectations, and be as detailed as possible.</p>
            <p>Once we receive your requirements, we will assign an agent to deal with you personally. They will talk to you to better understand your needs and expectations, and to answer your questions. Then, they will prepare a personalized offer for you; it includes our services, and their cost .</p>
            <p>You have the right to accept or decline it.</p>
            <div class="flex flex-wrap mt-4" id="tabs-id">
                <div class="w-full flex flex-col md:flex-row  items-start">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                        <div class="px-4 py-5 flex-auto">
                            <div class="block" id="tab-inbox">
                                <proxima-chat app_url="{{env('APP_URL')}}" customer_id="{{$loggedInCustomer}}" ></proxima-chat>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
