@include('admin.layout.header')
<title>Pengaturan Pembayaran | BK</title>

<div class="page-header">
    <h1 class="page-title">
        <img src={{ asset('img/icon/setting-icon.png') }} alt="Icon Setting" class="title-icon">
        Pengaturan Pembayaran
    </h1>
</div>

@if (session('success'))
    <div class="alert alert-success" style="margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
@endif

<div class="order-container">
    @foreach($payments as $payment)
        <div style="background: white; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h2 style="margin-top: 0; margin-bottom: 1rem; color: #111827; font-size: 1.25rem;">
                {{ $payment->label ?? ucfirst($payment->payment_method) }}
            </h2>
            
            <form method="POST" action="{{ route('admin.setting.payment.update', $payment->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div style="display: grid; gap: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Label</label>
                        <input type="text" name="label" value="{{ old('label', $payment->label) }}" 
                               style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Nomor Rekening/Nomor</label>
                        <input type="text" name="account_number" value="{{ old('account_number', $payment->account_number) }}" 
                               style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Nama Pemilik</label>
                        <input type="text" name="account_name" value="{{ old('account_name', $payment->account_name) }}" 
                               style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Gambar QRIS</label>
                        @if($payment->qris_image)
                            <div style="margin-bottom: 0.5rem;">
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($payment->qris_image) }}" 
                                     alt="QRIS" 
                                     style="max-width: 200px; max-height: 200px; border: 2px solid #e5e7eb; border-radius: 8px;">
                            </div>
                        @endif
                        <input type="file" name="qris_image" accept="image/*" 
                               style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px;">
                        <small style="color: #666; font-size: 12px;">Format: JPG, PNG. Max: 2MB</small>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Instruksi Pembayaran</label>
                        <textarea name="instructions" rows="3" 
                                  style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px;">{{ old('instructions', $payment->instructions) }}</textarea>
                    </div>
                    
                    <div>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1" {{ $payment->is_active ? 'checked' : '' }}>
                            <span>Aktif</span>
                        </label>
                    </div>
                    
                    <div>
                        <button type="submit" style="background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endforeach
</div>

@include('admin.layout.footer')

