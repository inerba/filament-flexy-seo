<x-mail::message>

# Conferma ordine #{{ $order->id }}

Gentile **{{ $order->customer->name }}**,

La ringraziamo per aver effettuato un ordine presso **CLUSTER-A**.
Di seguito Le riportiamo i dettagli dell’operazione.

---

### 📦 Dettaglio Articoli
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:18px;">
    <thead>
        <tr>
            <th align="left" style="padding:8px 6px; border-bottom:1px solid #e9e9e9; font-weight:600;">Articolo</th>
            <th align="center" style="padding:8px 6px; border-bottom:1px solid #e9e9e9; font-weight:600;">Qta</th>
            <th align="right" style="padding:8px 6px; border-bottom:1px solid #e9e9e9; font-weight:600;">Prezzo</th>
            <th align="right" style="padding:8px 6px; border-bottom:1px solid #e9e9e9; font-weight:600;">Subtotale</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotalCents = 0; @endphp
        @foreach ($order->items as $item)
            @php
                $unitPrice = $item->price;
                $lineTotal = ($item->quantity * $item->price);
                $grandTotalCents += $item->quantity * $item->price;
            @endphp
            <tr>
                <td style="padding:10px 6px; border-bottom:1px solid #f4f4f4;">{{ $item->name }}</td>
                <td align="center" style="padding:10px 6px; border-bottom:1px solid #f4f4f4;">{{ $item->quantity }}</td>
                <td align="right" style="padding:10px 6px; border-bottom:1px solid #f4f4f4;">€{{ number_format($unitPrice, 2) }}</td>
                <td align="right" style="padding:10px 6px; border-bottom:1px solid #f4f4f4;">€{{ number_format($lineTotal, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" align="right" style="padding:10px 6px; font-weight:700;">Totale complessivo:</td>
            <td align="right" style="padding:10px 6px; font-weight:700;">€ {{ number_format($grandTotalCents, 2) }}</td>
        </tr>
    </tfoot>
</table>

---

### 🚚 Informazioni di Spedizione

- **Indirizzo di consegna:** {{ $order->shipping_address['line1'] }}, {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['postal_code'] }}, {{ $order->shipping_address['country'] }}

---

### ℹ️ Note Aggiuntive

La presente comunicazione costituisce conferma dell’ordine ricevuto.
Per eventuali chiarimenti o necessità di assistenza, La invitiamo a contattarci:
<x-mail::button :url="route('shop.view-order', ['orderId' => $order->id])" :color="'success'">
Visita il tuo ordine
</x-mail::button>

Cordiali saluti,

Lo Staff di CLUSTER-A
</x-mail::message>
