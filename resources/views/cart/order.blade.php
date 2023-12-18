<x-filament-panels::page>
    @php
        $order = $this->receipt();
        $carts = $order->carts;
        $value = $order->value;
        function formatMoney($number, $fractional=false) {
            if ($fractional) {
                $number = sprintf('%.2f', $number);
            }
            while (true) {
                $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
                if ($replaced != $number) {
                    $number = $replaced;
                } else {
                    break;
                }
            }
            return $number . " ₫";
        }
    @endphp
    <button onclick="printDiv()" style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 dark:bg-custom-500 dark:hover:bg-custom-400 focus-visible:ring-custom-500/50 dark:focus-visible:ring-custom-400/50 fi-ac-btn-action">
        <span class="fi-btn-label">
            Print
        </span>
    </button>
    <div class="container mx-auto mt-8 p-8 bg-white shadow-md" id="receipt">

        <h1 class="text-3xl font-bold text-center mb-4">Receipt for CieloPos</h1>

        <div class="flex justify-between mb-4">
            <div>
                <p><strong>Date:</strong> {{\Carbon\Carbon::parse($order->created_at)->setTimezone('GMT+7')->format('d/m/Y')}}</p>
                <p><strong>Time:</strong> {{\Carbon\Carbon::parse($order->created_at)->setTimezone('GMT+7')->format('H:i:s')}}</p>
                <p><strong>Receipt:</strong> {{$order->id}}</p>
                <p><strong>Cashier:</strong> {{$order->user->name}}</p>
            </div>
            <div>
                <p><strong>Client Name:</strong> {{$order->client->name}}</p>
                <p><strong>Client Phone:</strong> {{$order->client->mobile}}</p>
            </div>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="border border-gray-300 py-2">Item</th>
                <th class="border border-gray-300 py-2">Quantity</th>
                <th class="border border-gray-300 py-2">Unit Price</th>
                <th class="border border-gray-300 py-2">Price</th>
                <th class="border border-gray-300 py-2">Tax</th>
                <th class="border border-gray-300 py-2">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($carts as $product_key => $item)
                @if(array_key_exists(0, $item))
                    <tr>
                        <td class="border border-gray-300 py-2">{{$item[0]['name']}}</td>
                        <td class="border border-gray-300 py-2">{{$item[0]['quantity']}}</td>
                        <td class="border border-gray-300 py-2">item(s)</td>
                        <td class="border border-gray-300 py-2">{{$item[0]['price']}}</td>
                        <td class="border border-gray-300 py-2">{{$item[0]['tax']}}%</td>
                        <td class="border border-gray-300 py-2">{{formatMoney($item[0]['quantity'] * $item[0]['price'] * ((100+$item[0]['tax'])/100))}}</td>
                    </tr>
                @endif
                @if(array_key_exists(1, $item))
                    <tr>
                        <td class="border border-gray-300 py-2">{{$item[1]['name']}}</td>
                        <td class="border border-gray-300 py-2">{{$item[1]['quantity']}}</td>
                        <td class="border border-gray-300 py-2">box(es)</td>
                        <td class="border border-gray-300 py-2">{{$item[1]['price']}}</td>
                        <td class="border border-gray-300 py-2">{{$item[1]['tax']}}%</td>
                        <td class="border border-gray-300 py-2">{{formatMoney($item[1]['quantity'] * $item[1]['price'] * ((100+$item[1]['tax'])/100))}}</td>
                    </tr>
                @endif
                @if(array_key_exists(3, $item))
                    <tr>
                        <td class="border border-gray-300 py-2">{{$item[3]['name']}}</td>
                        <td class="border border-gray-300 py-2">1</td>
                        <td class="border border-gray-300 py-2">{{$item[3]['type']}} Coupon</td>
                        <td class="border border-gray-300 py-2">{{$item[3]['price']}}</td>
                        <td class="border border-gray-300 py-2">0</td>
                        <td class="border border-gray-300 py-2">{{formatMoney($item[3]['price'])}}</td>
                    </tr>
                @endif
            @endforeach
            <!-- Add more rows as needed -->
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" class="border border-gray-300 py-2 text-right">Subtotal</td>
                <td class="border border-gray-300 py-2">{{formatMoney($value['subtotal'])}}</td>
            </tr>
            <tr>
                <td colspan="5" class="border border-gray-300 py-2 text-right">Tax</td>
                <td class="border border-gray-300 py-2">{{formatMoney($value['vat'])}}</td>
            </tr>
            <tr>
                <td colspan="5" class="border border-gray-300 py-2 text-right">Discount</td>
                <td class="border border-gray-300 py-2">{{formatMoney($value['discount'])}}</td>
            </tr>
            <tr>
                <td colspan="5" class="border border-gray-300 py-2 text-right">Total</td>
                <td class="border border-gray-300 py-2">{{formatMoney($value['total_due'])}}</td>
            </tr>
            </tfoot>
        </table>

    </div>

    <script>
        let receipt = document.getElementById('receipt');
        // print selected div
        function printDiv() {
            let printContents = receipt.innerHTML;
            let originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

    </script>
</x-filament-panels::page>
