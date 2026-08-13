<div style="font-family: sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
    <div style="background: #ea580c; color: white; padding: 10px; text-align: center; border-radius: 5px 5px 0 0;">
        <h2>Pesan Baru dari Portofolio</h2>
    </div>
    <div style="padding: 20px;">
        <p><strong>Nama:</strong> {{ $details['name'] }}</p>
        <p><strong>Email:</strong> {{ $details['email'] }}</p>
        <p><strong>Pesan:</strong></p>
        <p style="background: #f9f9f9; padding: 15px; border-left: 4px solid #ea580c;">{{ $details['message'] }}</p>
    </div>
</div>