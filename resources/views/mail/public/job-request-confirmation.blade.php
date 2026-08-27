<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { max-width: 200px; }
        .content { margin-bottom: 30px; }
        .footer { font-size: 0.8em; color: #777; text-align: center; border-top: 1px solid #eee; padding-top: 20px; }
        .highlight { color: #28a745; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Gemelli Car Garage</h2>
        </div>
        <div class="content">
            <p>Gentile <strong>{{ $jobRequest->name }}</strong>,</p>
            <p>Ti confermiamo di aver ricevuto correttamente la tua richiesta per il servizio di <strong>{{ $jobRequest->service?->name }}</strong> per la tua auto <strong>{{ $jobRequest->brand }} {{ $jobRequest->model }}</strong>.</p>

            <p>Il nostro team sta già analizzando i dettagli della tua richiesta. Ti contatteremo telefonicamente al numero <span class="highlight">{{ $jobRequest->phone }}</span> nel più breve tempo possibile per fornirti maggiori informazioni e confermare l'appuntamento.</p>

            <p>Stima indicativa del preventivo: <strong>€{{ number_format($jobRequest->estimated_price, 2) }}</strong></p>

            <p>Grazie per aver scelto <strong>Gemelli Car Garage</strong>!</p>
        </div>
        <div class="footer">
            <p>Viale della repubblica 30, Melegnano 20077<br>
            Tel: +39 324 801 9211<br>
            gemellicargarage@gmail.com</p>
            <p>&copy; {{ date('Y') }} Gemelli Car Garage. Professional Detailing Studio.</p>
        </div>
    </div>
</body>
</html>
