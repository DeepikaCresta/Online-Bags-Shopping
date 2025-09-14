<x-app-layout>
    <div style="height:20rem; place-content: center;">
        <div class="py-[2rem]">
            <div class="px-[1rem] 2xs:px-[1.5rem] sm:px-[3rem] lg:px-[5.9rem]">
                <div class="flex justify-center items-center flex-col p-[5rem]">
                    <div class="space-y-[3rem] shadow-xl p-[5rem]">
                        <div class="h-[3rem] w-[8rem]">
                            <img src="{{asset('assets/imgs/esewa.png')}}" alt="esewa" class="h-full w-full">
                        </div>
                        <div>
                            <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
                                <input type="hidden" id="amounts" name="amount" value="{{ $paymentData['amount'] }}" required>
                                <input type="hidden" id="tax_amount" name="tax_amount" value="{{ $paymentData['tax_amount'] }}" required>
                                <input type="hidden" id="total_amount" name="total_amount" value="{{ $paymentData['total_amount'] }}" required>
                                <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="{{ $paymentData['transaction_uuid'] }}"required>
                                <input type="hidden" id="product_code" name="product_code" value ="EPAYTEST" required>
                                <input type="hidden" id="product_service_charge" name="product_service_charge" value="{{ $paymentData['product_service_charge'] }}" required>
                                <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="{{ $paymentData['product_delivery_charge'] }}" required>
                                <input type="hidden" id="success_url" name="success_url" value="{{ $paymentData['success_url'] }}" required>
                                <input type="hidden" id="failure_url" name="failure_url" value="{{ $paymentData['failure_url'] }}" required>
                                <input type="hidden" id="signed_field_names" name="signed_field_names" value="{{ $paymentData['signed_field_names'] }}" required>
                                <input type="hidden" id="signature" name="signature" value="{{ $paymentData['signature'] }}" required>
                                <!-- <button type="submit">Proceed</button> -->
                                <button type="submit" class="flex items-center mx-auto text-center text-white bg-[#F28C28] font-semibold hover:bg-[#c2660c] focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-[.7rem] xs:text-[.95rem] px-5 py-2.5 h-[2.03rem] xs:h-[2.5rem] focus:outline-none">Proceed</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>