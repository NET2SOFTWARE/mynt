@extends('layouts.app')
@section('nav')
    @component('components.nav', ['guard' => 'user'])
    @endcomponent
@endsection

@section('content')
<html>
    <head>
        <title>Term & Condition</title>
        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
 
        <style>
            html, body {
                height: 100%;
            }
 
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
            }
 
            .container {
                text-align: center;
                display: table-cell;
            }
 
            .content {
                display: inline-block;
            }
 
            .title {
                font-size: 18px;
            }
            .isi{
             font-size: 16px;   
             text-align: left;
             margin-left: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title"><p>TERMS AND CONDITIONS OF THE BILL PAYMENT SERVICE *(EXAMPLE)<br></div>
SERVICE DEFINITIONS<br>
<div class="isi">
"Service" means the Bill Payment Service offered by Union Savings Bank, through CheckFree Services Corporation.<br>
"Agreement" means these Terms and Conditions of the bill payment service.<br>
"Payee" is the person or entity to which you wish a bill payment to be directed or is the person or entity from which you receive electronic bills, as the case may be.<br>
"Payment Instruction" is the information provided by you to the Service for a bill payment to be made to the Payee (such as, but not limited to, Payee name, Payee account number, and Scheduled Payment Date).<br>
"Payment Account" is the checking account from which bill payments will be debited.<br>
"Billing Account" is the checking account from which all Service fees will be automatically debited.<br>
"Scheduled Payment Date" is the day you want your Payee to receive your bill payment and is also the day your Payment Account will be debited, unless the Scheduled Payment Date falls on a non-Business Day in which case it will be considered to be the previous Business Day.<br>
"Due Date" is the date reflected on your Payee statement for which the payment is due. It is not the late date or grace period.<br>
"Scheduled Payment" is a payment that has been scheduled through the Service but has not begun processing.<br><br>
PAYMENT SCHEDULING<br>
Transactions begin processing four (4) Business Days prior to your Scheduled Payment Date. Therefore, the application will not permit you to select a Scheduled Payment Date less than four (4) Business Days from the current date. When scheduling payments you must select a Scheduled Payment Date that is no later than the actual Due Date reflected on your Payee statement unless the Due Date falls on a non-Business Day. If the actual Due Date falls on a non-Business Day, you must select a Scheduled Payment Date that is at least one (1) Business Day before the actual Due Date. Scheduled Payment Dates should be prior to any late date or grace period.

</div>
</p>
            </div>
        </div>
    </body>
</html>
@component('components.footer')
    @endcomponent
@endsection