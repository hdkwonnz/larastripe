{{-- www.youtube.com/watch?v=1dt-g5Au6ZI&list=PLeeuvNW2FHVixxKWVXqhjH1_5CPQ7nffP&index=5 ==> 참조 할 것.13/04/2020 --}}

@extends('layouts.app')

@section('content')
<div class="container">    
    <div class="col-md-12">
        <h1>Payment</h1>
        <div class="row">
            <div class="col-md-6">
                <form id="payment-form" action="{{ route('checkout.store') }}" method="POST" class="my-4">
                    @csrf
                    <div id="card-element">
                        <!-- Elements will create input elements here -->
                    </div>
                    
                    <!-- We'll put the error messages in this element -->
                    <div id="card-errors" role="alert"></div>
                    
                    <button class="btn btn-success mt-4 w-100" id="submit">Pay Now</button>
                </form>
                <div class="error_msg">
                    {{-- All errors will be displayed here... 내가 추가... --}}
                </div>          
            </div>            
        </div>        
    </div>   
</div>
@endsection

@section('extra-js')
{{-- www.youtube.com/watch?v=1dt-g5Au6ZI&list=PLeeuvNW2FHVixxKWVXqhjH1_5CPQ7nffP&index=5 ==> 참조 할 것.13/04/2020 --}}

<script src="https://js.stripe.com/v3/"></script>

<script>
    var stripe = Stripe("{{ env('STRIPE_PUB_KEY') }}");                         
    var elements = stripe.elements();
    var style = {
            base: {
            color: "#32325d",
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
                fontSize: "16px",
                    "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }        
    };
    var card = elements.create("card", { style: style, hidePostalCode: true });//hidePostalCode: true 내가추가...
    card.mount("#card-element");

    card.addEventListener('change', ({error}) => {
        const displayError = document.getElementById('card-errors');
        if (error) {
            displayError.classList.add('alert', 'alert-warning');
            displayError.textContent = error.message;
        } else {
            displayError.classList.remove('alert', 'alert-warning');
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');
    var submitButton = document.getElementById('submit');////
    var customerName = window.Laravel.user['name'];//views/layouts/app.blade.php의 script에서 정의한 값
    form.addEventListener('submit', function(ev) {
        ev.preventDefault();
        submitButton.disabled = true;////
        stripe.confirmCardPayment("{{ $clientSecret }}", { //$clientSecret => CheckoutController에서 받은 값
            payment_method: {
                card: card,
                billing_details: {
                    name: customerName ////
                }
            }
        }).then(function(result) {
            if (result.error) {
            // Show error to your customer (e.g., insufficient funds)
            submitButton.disabled = false;////            
            console.log(result.error.message);
            $('.error_msg').html("");////
            $('.error_msg').append(result.error.message).addClass('alert').addClass('alert-danger');////
            } else {
                // The payment has been processed!
                $('.error_msg').html("");////
                if (result.paymentIntent.status === 'succeeded') {
                    // Show a success message to your customer
                    // There's a risk of the customer closing the window before callback
                    // execution. Set up a webhook or plugin to listen for the
                    // payment_intent.succeeded event that handles any business critical
                    // post-payment actions.

                    console.log(result.paymentIntent);

                    var paymentIntent = result.paymentIntent;
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var url = form.action;
                    var redirect = '/mercy'; ////추후에 바꿀 것

                    fetch(
                        url,
                        {
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                            },
                            method: 'post',
                            body: JSON.stringify({
                                paymentIntent: paymentIntent
                            })
                        }
                    ).then((data) => {
                        
                        ////추후에 아래처럼 바꿀 것 CheckoutController@store를 먼저 고친 후에...
                        //// www.youtube.com/watch?v=HYk__gNN_D4&list=PLeeuvNW2FHVixxKWVXqhjH1_5CPQ7nffP&index=14
                        // if (data.status === 400) {
                        //     var redirect = '/boutique';
                        // } else {
                        //     var redirect = '/mercy';
                        // }

                        console.log(data)
                        window.location.href = redirect;////

                    }).catch((error) => {
                        console.log(error)
                    })
                }
            }
        });
    });
</script>
@endsection